let policyid = null
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

const unhideFormData = (elements) => {
  elements.forEach((element) => {
    const tagName = element.tagName.toLowerCase();

    if (tagName === "input") {
      if (element.type === "radio") {
        // Enable radio buttons
        element.style.pointerEvents = "";
        element.style.opacity = ""; // Reset the opacity
      } else {
        // Enable other input types
        element.readOnly = false;
        element.style.backgroundColor = ""; // Reset background color
        element.style.border = ""; // Reset border style
      }
    } else if (tagName === "select") {
      // Enable select elements
      element.style.pointerEvents = "";
      element.style.backgroundColor = ""; // Reset background color
      element.style.color = ""; // Reset text color
    } else if (tagName === "button") {
      // Enable button elements
      element.disabled = false;
      element.style.pointerEvents = "";
      element.style.opacity = ""; // Reset opacity
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
  const btnSaveDraftForm = document.getElementById('btnSaveDraftForm');
  id = urlParams.get("id");

  //หากไม่มีpolicy หรืออยู่step create quote
  if (!id) {
    paymentContainer.querySelectorAll("input, select").forEach((field) => {
      field.removeAttribute("required");
    });
    policyidText.style.display = "none"
    policyDisplay.style.display = "none";
    btnEditForm.style.display = "none";
  }

  if (id) {
    async function handleQuotation(id) {
      try {
        const response = await jQuery.agent.getQuotationWithId(id);
        if (response?.result !== "success") {
          throw new Error("Failed to fetch quotation");
        }

        console.log("Response:", response);
        setDefaultValueForm(response?.data);
        const extractData = extractQuotationData(response?.data);
        quotationData = extractData;
        policyid = response?.data?.policyId
        const policyId = response?.data?.policyId;
        const policyNo = response?.data?.policyNo;
        console.log("policyNo:", policyNo)

        if (policyId && !policyNo) {
          configureCreatePolicyState();
        } else if (policyNo) {
          // Policy already issued
          console.log("Issued Policy");
          hideAllFormElements();
        }

        if (policyId) {
          const paymentResponse = await jQuery.agent.getPaymentLogWithId(policyId);
          handlePaymentResponse(paymentResponse);
          responsePayment = paymentResponse?.data;

        }

        // Ensure payment container fields aren't marked as required
        paymentContainer.querySelectorAll("input, select").forEach((field) => {
          field.removeAttribute("required");
        });

      } catch (error) {
        console.error("Error occurred:", error);
      }
    }

    function configureCreatePolicyState() {
      btnSaveForm.textContent = "Create Policy";
      btnSaveForm.title = "Please make the payment";
      btnDraftForm.style.display = "none";

      paymentContainer.removeAttribute("hidden");

      const formElements = document.querySelectorAll(
        "input:not(#payment-container input), select:not(#payment-container select), button:not(#payment-container button):not(#btnSaveForm):not(#btnEditForm)"
      );
      hideFormData(formElements);
    }

    function hideAllFormElements() {
      const formElements = document.querySelectorAll("input, select, button");
      hideFormData(formElements);

      btnSaveDraftForm.style.display = "none";
      btnSaveForm.style.display = "none";
    }

    function handlePaymentResponse(paymentResponse) {
      btnSaveDraftForm.style.display = "none";

      if (paymentResponse?.data?.result !== "SUCCESS") {
        // Payment not successful
        btnSaveForm.disabled = true;
        btnSaveForm.style.opacity = "0.65";
        btnEditForm.style.display = "block";
      } else {
        // Payment successful
        console.log("paymentResponse:", paymentResponse)
        populatePaymentForm(paymentResponse?.data)
        const formElements = document.querySelectorAll(
          "input, select, button:not(#btnSaveForm)"
        );
        hideFormData(formElements);
        btnEditForm.style.display = "none";
      }
    }


    handleQuotation(id);
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
function populatePaymentForm(paymentData) {
  // Payment Mode
  const paymentModeSelect = document.querySelector('select[name="Payment_Mode"]');
  paymentModeSelect.value = paymentData.payment_mode;

  // Payment Frequency
  const paymentFrequencyAnnual = document.querySelector('#paymentFrequencyAnnual');
  const paymentFrequencyMonthly = document.querySelector('#paymentFrequencyMonthly');
  if (paymentData.payment_frequency === 1) {
    paymentFrequencyAnnual.checked = true;
  } else if (paymentData.payment_frequency === 2) {
    paymentFrequencyMonthly.checked = true;
  }

  // Card Type
  const cardTypeSelect = document.querySelector('select[name="Payment_CardType"]');
  cardTypeSelect.value = paymentData.card_type;

  // Card Number
  const cardNumberInput = document.querySelector('input[name="payment_cardNumber"]');
  cardNumberInput.value = paymentData.card_number;

  // Expiry Date (MM/YY)
  const expiryDateInput = document.querySelector('input[name="payment_expiryDate"]');
  expiryDateInput.value = `${paymentData.card_expiry_month}/${paymentData.card_expiry_year.slice(-2)}`; // Format as MM/YY

  // Security Code
  const securityCodeInput = document.querySelector('input[name="payment_securityCode"]');
  securityCodeInput.value = "XXX";
  const Amount = document.querySelector('input[name="payment_amount"]');
  Amount.value = `${paymentData.order_amount}(${paymentData.order_currency})`;
}
