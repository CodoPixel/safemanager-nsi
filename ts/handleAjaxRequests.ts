class AjaxRequest {
  protected xhr: XMLHttpRequest = new XMLHttpRequest();
  protected headers: [string, string][] = [["X-Requested-With", "xmlhttprequest"]];
  protected mimeType: string = "application/json";
  public onSuccess: (response: any) => void = () => {};
  public onError: (status: number) => void = () => {};

  public addRequestHeader(name: string, value: string): void {
    this.headers.push([name, value]);
  }

  public overrideMimeType(mimeType: string): void {
    this.mimeType = mimeType;
  }

  public open(method: "GET" | "POST", path: string, async: boolean = true): void {
    this.xhr.open(method.toUpperCase() === "POST" ? "POST" : "GET", path, async);
    this.xhr.overrideMimeType(this.mimeType);
    for (let header of this.headers) this.xhr.setRequestHeader(header[0], header[1]);

    this.xhr.onload = () => {
      if (this.xhr.readyState === XMLHttpRequest.DONE) {
        if (this.xhr.status === 200) {
          let parsedResponse;
          try {
            parsedResponse = JSON.parse(this.xhr.response);
          } catch {
            console.error("The response cannot be parsed :", this.xhr.response);
            return this.onError(500);
          }
          this.onSuccess(parsedResponse);
        } else {
          this.onError(this.xhr.status);
        }
      }
    };
  }

  public send(data?: any): void {
    this.xhr.send(data);
  }
}
