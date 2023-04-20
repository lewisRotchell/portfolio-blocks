let payload = {
  cat: false,
  s: false,
};

let timeoutId;

const urlParams = new URLSearchParams(window.location.search);
const search = document.querySelector(".posts-display__search");
const categories = document.querySelector(".posts-display__categories");

if (search) {
  search.addEventListener("keyup", (e) => {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(function () {
      payload.s = e.target.value;
      urlParams.delete("pages");
      urlParams.set("search", e.target.value);
      const newRelativePathQuery =
        window.location.pathname + "?" + urlParams.toString();
      history.pushState(null, "", newRelativePathQuery);
      apiRequest();
    }, 500);
  });
}

if (categories) {
  categories.addEventListener("change", (e) => {
    payload.cat = e.target.value;
    apiRequest();
  });
}

async function apiRequest() {
  const response = await fetch("/wp-json/portfolio/v1/posts-display", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(payload),
  });
  const data = await response.json();
  document.querySelector(".posts-display__container").innerHTML = data;
  console.log(data);
}
