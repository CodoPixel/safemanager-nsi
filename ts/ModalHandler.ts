(function () {
  /**
   * @class Defines what's a focusable element.
   */
  class FocusableElement {
    /**
     * The list of the default focusable elements.
     * @type {Array<string>}
     */
    public defaultFocusableHTMLElements: string[] = [
      "a",
      "button",
      "input",
      "textarea",
      "select",
      "summary", // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/details
    ];

    /**
     * The query selector of the focusable elements.
     * @type {string}
     */
    public focusableQuerySelector: string =
      this.defaultFocusableHTMLElements.join(",") + ",[tabindex='0']";

    /**
     * The rules that must be respected by an element in order to be focusable.
     * Each rule needs to return `true` in order for the element to be considered as focusable.
     * @type {Array<Function>}
     */
    public RULES: ((el: HTMLElement) => boolean)[] = [
      (el) => !this.hasStyle(el, "display", "none"),
      (el) => !this.hasStyle(el, "visibility", "hidden"),
      (el) => !el.hasAttribute("disabled"),
      (el) => !el.hasAttribute("hidden"),
      (el) => (el.tagName == "input" ? (el as HTMLInputElement).type != "hidden" : true),
    ];

    /**
     * Checks if an element has a specific CSS property and a specific value for this property.
     * @param {HTMLElement} el The HTML Element.
     * @param {string} property The name of the CSS property.
     * @param {string} value The value of the CSS property.
     * @returns {boolean} True if the element has this property & this value for this CSS property.
     */
    public hasStyle(el: HTMLElement, property: string, value: string): boolean {
      const computed = window.getComputedStyle(el); // we must check in both CSS declaration & style attribute.
      return el.style[property as any] == value || computed.getPropertyValue(property) == value;
    }

    /**
     * Checks if an element is focusable.
     * @param {HTMLElement} el The HTML Element.
     * @returns {boolean} True if the element is focusable.
     */
    public isFocusable(el: HTMLElement): boolean {
      for (let rule of this.RULES) {
        if (rule(el) === false) {
          return false;
        }
      }

      return true;
    }

    /**
     * Gets all the focusable elements.
     * @param {HTMLElement} parent The parent element. By default `document.body`.
     * @returns {Array<HTMLElement>} All the focusable children of an element.
     */
    public getKeyboardFocusableElements(parent: HTMLElement = document.body): HTMLElement[] {
      const children = Array.from(
        parent.querySelectorAll(this.focusableQuerySelector)
      ) as HTMLElement[];
      return children.filter((el) => this.isFocusable(el));
    }
  }

  /**
   * @class Manages the modals on a page.
   */
  class ModalHandler {
    /**
     * The currently opened modal.
     * @type {HTMLElement|null}
     * @default null
     * @public
     */
    public current_modal: HTMLElement | null = null;

    /**
     * The previously focused element (the element that had the focus before opening the modal).
     * @type {HTMLElement|null}
     * @default null
     * @private
     */
    private previouslyFocusedElement: HTMLElement | null = null;

    /**
     * The focusable elements in the modal.
     * @type {Array<HTMLElement>|null}
     * @default null
     * @private
     */
    private focusables: HTMLElement[] | null = null;

    /**
     * An instance of FocusableElement.
     * @type {FocusableElement}
     * @private
     */
    private instanceOfFocusableElement: FocusableElement = new FocusableElement();

    /**
     * Opens a modal.
     * @param {string} queryselector The modal to be selected & opened.
     */
    public open(queryselector: string): void {
      if (this.isOpen()) {
        this.close();
      }

      this.current_modal = document.querySelector(queryselector);
      if (!this.current_modal) {
        throw new Error("The modal '" + queryselector + "' does not exist.");
      }

      this.previouslyFocusedElement = document.querySelector(":focus");
      this.current_modal.setAttribute("aria-hidden", "false");
      this.focusables = this.instanceOfFocusableElement.getKeyboardFocusableElements(
        this.current_modal
      );
      if (this.focusables && this.focusables[0]) this.focusables[0].focus();

      this.current_modal.onclick = (e) => {
        const target = e.target as HTMLElement;
        if (this.current_modal) {
          const wrapper = this.current_modal.querySelector(".modal-wrapper");
          if (wrapper && !wrapper.contains(target)) {
            this.close();
          }
        }
      };

      document.onkeydown = (e: KeyboardEvent) => {
        this._handleKeyboardSupport(e);
      };

      const closebutton = this.current_modal.querySelector(".modal-close") as HTMLElement;
      if (closebutton)
        closebutton.onclick = () => {
          this.close();
        };
    }

    private _handleKeyboardSupport(e: KeyboardEvent): void {
      if (e.key === "Escape" || e.key === "Esc" || e.keyCode === 27) {
        if (this.isOpen()) this.close();
      }

      if (e.key === "Tab" || e.keyCode === 9) {
        if (this.isOpen()) this._focusInModal(e);
      }
    }

    /**
     * Checks if there is an open modal.
     * @returns {boolean} True if there is an open modal.
     */
    public isOpen(): boolean {
      return this.current_modal !== null;
    }

    /**
     * Closes the currently open modal. Does nothing if there is no open modal.
     */
    public close(): void {
      if (this.current_modal) {
        this.current_modal.setAttribute("aria-hidden", "true");
        if (this.previouslyFocusedElement) {
          this.previouslyFocusedElement.focus();
        }

        this.current_modal = null;
      }
    }

    /**
     * Blocks the focus inside the modal while it's open.
     * @param {KeyboardEvent} e The keyboard event.
     */
    private _focusInModal(e: KeyboardEvent): void {
      e.preventDefault();
      if (this.current_modal) {
        const focusables = this.instanceOfFocusableElement.getKeyboardFocusableElements(
          this.current_modal
        );
        if (focusables) {
          let index = focusables.findIndex((f) =>
            this.current_modal ? f === this.current_modal.querySelector(":focus") : false
          );
          if (e.shiftKey === true) {
            index--;
          } else {
            index++;
          }
          if (index >= focusables.length) {
            index = 0;
          }
          if (index < 0) {
            index = focusables.length - 1;
          }
          focusables[index].focus();
        }
      }
    }
  }

  // We dont want to initialize a class without any constructor,
  // therefore we do it here so that we can access it from anywhere.
  (window as any).ModalHandler = new ModalHandler();
})();
