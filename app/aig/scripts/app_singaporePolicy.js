let policyid = null;
document.addEventListener("DOMContentLoaded", function()  {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const paymentContainer = document.getElementById("payment-container");
  policyid = urlParams.get("policyid");
  console.log("policyid:", policyid);
  if(!policyid){
    paymentContainer.querySelectorAll("input, select").forEach((field) => {
        field.removeAttribute("required");
      });
  }
  if (policyid) {
    const addCoverButton = document.querySelector(".add-cover");
    const seePlanButton = document.querySelector(".seePlan");
    
    paymentContainer.removeAttribute("hidden");
    if (addCoverButton) {
        addCoverButton.setAttribute("hidden", "true");
      }
      
      if (seePlanButton) {
        seePlanButton.setAttribute("hidden", "true");
      }
    const formElements = document.querySelectorAll(
      "input:not(#payment-container input), select:not(#payment-container select)"
    );
    formElements.forEach((element) => {
      element.disabled = true;
    });

    jQuery.agent
      .getQuotationWithId(policyid)
      .then((response) => {
        if (response?.result == "success") {
          console.log("Response:", response);
          setDefaultValueForm(response?.data);
        }
      })
      .catch((error) => {
        console.log("Error occurred:", error);
      });
  }
});
