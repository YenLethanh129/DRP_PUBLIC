window.addEventListener("load", () => {
    const loader = document.querySelector(".loader");
    const loaderContainer = document.querySelector(".loader_container");

    loader.classList.add("loader-hidden");
    loaderContainer.classList.add("loader-hidden");


    loader.addEventListener("animationend", () => {
      document.body.removeChild(loaderContainer);
    });
  });
  