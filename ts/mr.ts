const alpha = "abcdefghijklmnopqrstuvwxyz";

function mr() {
  const xm = new XMLHttpRequest();
  xm.onreadystatechange = function () {
    if (xm.readyState == 4) {
      if (xm.status == 200) {
        const response = xm.responseText;
        for (let letter of Array.from(alpha)) {
          const regex = new RegExp("\\n" + letter + "\\S+", "gi");
          const formattedText = response.match(regex)?.join("");
        }
      }
    }
  };
  xm.open("GET", "dict/fr.txt");
  xm.setRequestHeader("Access-Control-Allow-Origin", "*");
  xm.send();
}
