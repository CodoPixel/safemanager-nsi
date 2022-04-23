"use strict";
class AjaxRequest {
    xhr = new XMLHttpRequest();
    headers = [["X-Requested-With", "xmlhttprequest"]];
    mimeType = "application/json";
    onSuccess = () => { };
    onError = () => { };
    addRequestHeader(name, value) {
        this.headers.push([name, value]);
    }
    overrideMimeType(mimeType) {
        this.mimeType = mimeType;
    }
    open(method, path, async = true) {
        this.xhr.open(method.toUpperCase() === "POST" ? "POST" : "GET", path, async);
        this.xhr.overrideMimeType(this.mimeType);
        for (let header of this.headers)
            this.xhr.setRequestHeader(header[0], header[1]);
        this.xhr.onload = () => {
            if (this.xhr.readyState === XMLHttpRequest.DONE) {
                if (this.xhr.status === 200) {
                    let parsedResponse;
                    try {
                        parsedResponse = JSON.parse(this.xhr.response);
                    }
                    catch {
                        console.error("The response cannot be parsed :", this.xhr.response);
                        return this.onError(500);
                    }
                    this.onSuccess(parsedResponse);
                }
                else {
                    this.onError(this.xhr.status);
                }
            }
        };
    }
    send(data) {
        this.xhr.send(data);
    }
}
