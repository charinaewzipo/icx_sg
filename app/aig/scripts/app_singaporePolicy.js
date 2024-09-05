let policyid = null;
let statusPayment = null;
const hideFormData = (elements) => {
  elements.forEach((element) => {
    const tagName = element.tagName.toLowerCase();

    if (tagName === "input") {
      if (element.type === "radio") {
        // Style and disable radio buttons
        element.style.pointerEvents = "none";
        element.style.opacity = "0.5"; // Visual indication of being disabled
      } else {
        // Style and disable other input types
        element.readOnly = true;
        element.style.backgroundColor = "#e9ecef";
        element.style.border = "1px solid rgb(118, 118, 118)";
      }
    } else if (tagName === "select") {
      // Style and disable select elements
      element.style.pointerEvents = "none";
      element.style.backgroundColor = "#e9ecef";
      element.style.color = "#6c757d";
    } else if (tagName === "button") {
      // Disable button elements
      element.disabled = true;
      element.style.pointerEvents = "none";
      element.style.opacity = "0.65"; // Visual indication of being disabled
    }
  });
};

document.addEventListener("DOMContentLoaded", function () {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const paymentContainer = document.getElementById("payment-container");
  const policyidText = document.getElementById("policyid-text");
  const policyInput = document.getElementById('policyid-input');
  const policyDisplay = document.getElementById('policyid-display');
  const btnDraftForm = document.getElementById('btnDraftForm');
  const btnEditForm = document.getElementById('btnEditForm');
  const btnSaveForm = document.getElementById('btnSaveForm');
  // Retrieve 'policyid' from the URL parameters
  policyid = urlParams.get("policyid");
  console.log("policyid:", policyid);



  //หากไม่มีpolicy หรืออยู่step create quote
  if (!policyid) {
    paymentContainer.querySelectorAll("input, select").forEach((field) => {
      field.removeAttribute("required");
    });
    policyidText.style.display = "none"
    policyDisplay.style.display = "none";
    btnEditForm.style.display = "none";
  }

  if (policyid) {
    const addCoverButton = document.querySelector(".add-cover");
    const seePlanButton = document.querySelector(".seePlan");
    btnDraftForm.style.display = "none";
    policyInput.value = policyid
    paymentContainer.removeAttribute("hidden");



    if (addCoverButton) {
      addCoverButton.setAttribute("hidden", "true");
    }

    if (seePlanButton) {
      seePlanButton.setAttribute("hidden", "true");
    }


    const formElements = document.querySelectorAll(
      "input:not(#payment-container input), select:not(#payment-container select), button:not(#payment-container button):not(#btnSaveForm):not(#btnEditForm)"
    );


    hideFormData(formElements)

    $("#datepicker, #datepicker2, #datepicker3, #datepicker4, #datepicker5, #datepicker6").each(function () {
      $(this).attr("readonly", true).on('focus', function (event) {
        event.preventDefault(); // Prevent datepicker from opening
      });
    });



    // Fetch the quotation data with the policy ID
    jQuery.agent
      .getQuotationWithId(policyid)
      .then((response) => {
        if (response?.result == "success") {
          console.log("Response:", response);
          setDefaultValueForm(response?.data);
          const extractData = extractQuotationData(response?.data);
          quotationData = extractData;
        }
      })
      .catch((error) => {
        console.error("Error occurred:", error);
      });

    jQuery.agent
      .getPaymentLogWithId(policyid)
      .then((response) => {
        console.log("response:", response)

        //if payment successful but no policy
        if (response?.data?.result == "SUCCESS") {
          responsePayment = response?.data

          jQuery.agent.getPolicyCreateOrNot(policyid).then((response) => {
            //if policy was successfully created
            if (response?.result == "success") {
              btnSaveForm.setAttribute("hidden", "true");
            } else {
              paymentContainer.querySelectorAll("input, select").forEach((field) => {
                field.removeAttribute("required");
              });
            }

          })
          const paymentElements = document.querySelectorAll(
            "input, select, button:not(#btnSaveForm)"
          );

          hideFormData(paymentElements)
          btnDraftForm.setAttribute("hidden", "true");
          btnEditForm.setAttribute("hidden", "true");
        }
        // if no payment
        else {

        }
      })
      .catch((error) => {
        console.error("Error occurred:", error);
      });
  }

});
function extractQuotationData(data) {
  try {
    // Parse JSON strings if they are strings
    if (data.ncdInfo && typeof data.ncdInfo === 'string') {
      try {
        data.ncdInfo = JSON.parse(data.ncdInfo);
      } catch (e) {
        console.error("Error parsing ncdInfo:", e);
        data.ncdInfo = {}; // Default to an empty object if parsing fails
      }
    }

    if (data.policyHolderInfo && typeof data.policyHolderInfo === 'string') {
      try {
        data.policyHolderInfo = JSON.parse(data.policyHolderInfo);
      } catch (e) {
        console.error("Error parsing policyHolderInfo:", e);
        data.policyHolderInfo = {}; // Default to an empty object if parsing fails
      }
    }

    if (data.insuredList && typeof data.insuredList === 'string') {
      try {
        data.insuredList = JSON.parse(data.insuredList);
      } catch (e) {
        console.error("Error parsing insuredList:", e);
        data.insuredList = []; // Default to an empty array if parsing fails
      }
    }

    return data;
  } catch (error) {
    console.error("Error extracting quotation data:", error);
    return null;
  }
}