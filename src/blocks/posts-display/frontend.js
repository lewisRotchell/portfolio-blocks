let payload = {
  cat: false,
  s: false,
};

const search = document.querySelector(".posts-display__search");
const categories = document.querySelector(".posts-display__categories");

if (search) {
  search.addEventListener("keyup", (e) => {
    payload.s = e.target.value;
    console.log(payload);
    apiRequest();
  });
}

if (categories) {
  categories.addEventListener("change", (e) => {
    payload.cat = e.target.value;
    console.log(payload);
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
  console.log(data);
}
