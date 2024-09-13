window.onload = () => {
  let button = document.querySelector("#btn");
  button.addEventListener("click", calculateBMI);
  button.addEventListener("keydown", function(event) {
      if (event.key === "Enter") {
          event.preventDefault();
          calculateBMI();
      }
  });
};

/* Adjust as BMI of VietNamese 
        Link ref: https://www.vinmec.com/vi/tin-tuc/thong-tin-suc-khoe/cach-do-va-tinh-chi-so-bmi-theo-huong-dan-cua-vien-dinh-duong-quoc-gia/
*/

function calculateBMI() {
  let height = parseInt(document.querySelector("#height").value);
  let weight = parseInt(document.querySelector("#weight").value);
  let result = document.querySelector("#result");

  if (height === "" || isNaN(height))
      result.innerHTML = "Provide a valid Height!";
  else if (weight === "" || isNaN(weight))
      result.innerHTML = "Provide a valid Weight!";
  else {
      let bmi = (weight / ((height * height) / 10000)).toFixed(2);

      // Hiển thị kết quả
      if (bmi < 18.5)
          result.innerHTML = `Under Weight : <span>${bmi}</span>`;
      else if (bmi >= 18.5 && bmi < 24.9)
          result.innerHTML = `Normal : <span>${bmi}</span>`;
      else
          result.innerHTML = `Over Weight : <span>${bmi}</span>`;

  }
}
