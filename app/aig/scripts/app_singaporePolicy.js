let policyid = null;
document.addEventListener("DOMContentLoaded", () => {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  policyid = urlParams.get("policyid");
  console.log("policyid:", policyid);
  if (policyid) {
    const paymentContainer = document.getElementById("payment-container");
    paymentContainer.removeAttribute("hidden");
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
