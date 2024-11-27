let policyid = null
let statusPayment = null;
const hideFormData = (elements) => {
  // Disable datepickers
  disableDatepickers([
    "#datepicker", "#datepicker2", "#datepicker3", "#datepicker4", "#datepicker5",
    "#datepicker-1", "#datepicker-2", "#datepicker-3", "#datepicker-4", "#datepicker-5", "#datepicker-6"
  ]);

  elements.forEach((element) => {
    const tagName = element.tagName.toLowerCase();
    const commonStyles = {
      backgroundColor: "#e9ecef", // Light grey background
      border: "1px solid rgb(118, 118, 118)", // Light grey border
      opacity: "0.65" // Visual indication of being disabled
    };

    if (tagName === "input") {
      if (element.type === "radio") {
        // Disable radio buttons
        element.disabled = true; // Disable the radio button
        Object.assign(element.style, commonStyles); // Apply common styles
      } else {
        // Disable other input types
        // element.readOnly = true;
        Object.assign(element.style, commonStyles); // Apply common styles
      }
    } else if (tagName === "select") {
      // Disable select elements
      Object.assign(element.style, commonStyles); // Apply common styles
      element.style.pointerEvents = "none"; // Disable interactions
      element.style.color = "#6c757d"; // Grey out text
    } else if (tagName === "textarea") {
      // Disable textarea elements
      element.disabled = true;
      Object.assign(element.style, commonStyles); // Apply common styles
    } else if (tagName === "button") {
      // Disable button elements
      element.disabled = true;
      element.style.pointerEvents = "none";
      element.style.opacity = "0.65"; // Visual indication of being disabled
    }
  });
};


const disableDatepickers = (selectors) => {
  selectors.forEach((selector) => {
    $(selector).datepicker("disable");
  });
};
const enableDatepickers = (selectors) => {
  selectors.forEach((selector) => {
    $(selector).datepicker("enable");
  });
};


const unhideFormData = (elements) => {
  // Enable datepickers
  enableDatepickers([
    "#datepicker", "#datepicker2", "#datepicker3", "#datepicker4", "#datepicker5",
    "#datepicker-1", "#datepicker-2", "#datepicker-3", "#datepicker-4", "#datepicker-5", "#datepicker-6"
  ]);

  // Enable specific textarea by ID
  const remarkCTextArea = document.getElementById("RemarkCInput");
  if (remarkCTextArea) remarkCTextArea.disabled = false;

  // Iterate over each form element and reset its disabled/readOnly properties, ignoring readonly elements
  elements.forEach((element) => {
    // Ignore elements with readonly attribute
    if (element.hasAttribute('readonly')) return;
    
    const tagName = element.tagName.toLowerCase();

    if (tagName === "input") {
      if (element.type === "radio" || element.type === "checkbox") {
        // Enable radio and checkbox elements
        element.disabled = false;
        element.style.pointerEvents = "";  // Allow pointer events
        element.style.opacity = "";        // Reset opacity
        element.style.backgroundColor = "";// Reset background color
        element.style.border = "";         // Reset border style
      } else {
        // Enable other input types (text, number, etc.), unless they have readonly
        element.readOnly = false;          // Remove read-only restriction
        element.disabled = false;          // Ensure input is enabled
        element.style.backgroundColor = ""; // Reset background color
        element.style.border = "";         // Reset border style
        element.style.pointerEvents = "";  // Allow pointer events
        element.style.color = "";          // Reset text color
        element.style.opacity = "";        // Reset opacity
      }
    } else if (tagName === "select") {
      // Enable select elements
      element.disabled = false;           // Ensure select is enabled
      element.style.pointerEvents = "";   // Allow pointer events
      element.style.backgroundColor = ""; // Reset background color
      element.style.color = "";           // Reset text color
      element.style.border = "";          // Reset border style
      element.style.opacity = "";         // Reset opacity
    } else if (tagName === "textarea") {
      // Enable textarea elements, ignoring readonly ones
      element.readOnly = false;           // Remove read-only restriction
      element.disabled = false;           // Enable textarea
      element.style.backgroundColor = ""; // Reset background color
      element.style.border = "";
      element.style.opacity = "";           // Reset border style
    } else if (tagName === "button") {
      // Enable button elements
      element.disabled = false;           // Ensure button is enabled
      element.style.pointerEvents = "";   // Allow interaction
      element.style.opacity = "";         // Reset opacity
    }
  });
};



document.addEventListener("DOMContentLoaded", function () {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const paymentContainer = document.getElementById("payment-container");
  const paymentContainerAmount = document.getElementById("payment-container-amount");
  const remarkCTextArea = document.getElementById("RemarkCInput");
  const policyidText = document.getElementById("policyid-text");
  const policyInput = document.getElementById('policyid-input');
  const policyDisplay = document.getElementById('policyid-display');
  const btnDraftForm = document.getElementById('btnDraftForm');
  const btnEditForm = document.getElementById('btnEditForm');
  const btnSaveForm = document.getElementById('btnSaveForm');
  const btnSaveDraftForm = document.getElementById('btnSaveDraftForm');
  const ncdLevel_gears_display=document.getElementById("ncdLevel_gears_display");
  const ncdLevel_gears=document.getElementById("ncdLevel_gears");
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let formType = url.searchParams.get('formType');

  id = urlParams.get("id");

  //หากไม่มีpolicy หรืออยู่step create quote
  if (!id) {
    policyidText.style.display = "none"
    policyDisplay.style.display = "none";
    btnEditForm.style.display = "none";
    ncdLevel_gears_display.style.display = "none";
    ncdLevel_gears.style.display = "none";
  }

  if (id) {

    async function handleQuotation(id) {
      try {
        const response = await jQuery.agent.getQuotationWithId(id);
        if (response?.result !== "success") {
          throw new Error("Failed to fetch quotation");
        }

        console.log("Response:", response);
        await getProductDetail(response?.data?.productId);
        await setDefaultValueForm(response?.data);

        const extractData = extractQuotationData(response?.data);
        quotationData = extractData;
        policyid = response?.data?.policyId
        const policyId = response?.data?.policyId;
        const policyNo = response?.data?.policyNo;
        console.log("policyNo:", policyNo)
        const Amount = document.querySelector('input[name="payment_amount"]');
        if (Amount) {
          Amount.value = `${response?.data?.premiumPayable}(SGD)`;
        }
        if (policyId && !policyNo) {
          configureCreatePolicyState();
        } else if (policyNo) {
          // Policy already issued
          console.log("Issued Policy");
          hideAllFormElements();
        }

        if (policyId && quotationData?.quoteNo) {
          try {
            const paymentResponse = await jQuery.agent.getPaymentLogWithId(quotationData?.quoteNo);
            handlePaymentResponse(paymentResponse);
            responsePayment = paymentResponse?.data;
            handleAlertNCDLevelDifferent()
          } catch (error) {
            console.log("error:", error)
          }

        }

        paymentContainer.querySelectorAll("input, select").forEach((field) => {
          field.removeAttribute("required");
        });
        
 
        if (formType === "auto" && quotationData?.quoteNo) {
          document.getElementById("premium-amount-label").hidden = true;
          document.getElementById("premium-amount-withgst-label").hidden = true;
        }
      } catch (error) {
        console.error("Error occurred:", error);
      }
    }

    function configureCreatePolicyState() {
      btnSaveForm.textContent = "Create Policy";
      btnSaveForm.title = "Please make the payment";
      btnDraftForm.disabled = false
      remarkCTextArea.disabled = true;
      paymentContainer.removeAttribute("hidden");
      paymentContainerAmount.removeAttribute("hidden");

      const formElements = document.querySelectorAll(
        "input:not(#payment-container-amount input), select:not(#payment-container-amount select), button:not(#payment-container-amount button):not(#btnEditForm):not(#btnSaveForm),textarea"
      );

      hideFormData(formElements);

    }

    function hideAllFormElements() {
      const formElements = document.querySelectorAll("input, select, button,textarea");
      hideFormData(formElements);

      btnSaveDraftForm.style.display = "none";
      btnSaveForm.style.display = "none";
      remarkCTextArea.disabled = true;
    }

    function handlePaymentResponse(paymentResponse) {
      console.log("paymentResponse:", paymentResponse)
      btnSaveDraftForm.style.display = "none";

      if (paymentResponse?.data?.result !== "SUCCESS") {
        // Payment not successful
        btnSaveForm.disabled = true;
        btnSaveForm.style.opacity = "0.65";
        btnEditForm.style.display = "block";
      } else {
        // Payment successful
        console.log("paymentResponse:", paymentResponse)
        const cardNumberContainer = document.getElementById('card-number-container');
        const cardExpiryContainer = document.getElementById('card-expiry-container');

        cardNumberContainer.hidden = false;
        cardExpiryContainer.hidden = false;
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
  // const paymentModeSelect = document.querySelector('select[name="Payment_Mode"]');
  // paymentModeSelect.value = paymentData.payment_mode;

  // Payment Frequency
  // const paymentFrequencyAnnual = document.querySelector('#paymentFrequencyAnnual');
  // const paymentFrequencyMonthly = document.querySelector('#paymentFrequencyMonthly');
  // if (paymentData.payment_frequency === 1) {
  //   paymentFrequencyAnnual.checked = true;
  // } else if (paymentData.payment_frequency === 2) {
  //   paymentFrequencyMonthly.checked = true;
  // }

  // Card Type
  // const cardTypeSelect = document.querySelector('select[name="Payment_CardType"]');
  // cardTypeSelect.value = paymentData.card_type;

  // Card Number
  const cardNumberInput = document.querySelector('input[name="payment_cardNumber"]');
  cardNumberInput.value = paymentData.card_number;

  // Expiry Date (MM/YY)
  const expiryDateInput = document.querySelector('input[name="payment_expiryDate"]');
  expiryDateInput.value = `${paymentData.card_expiry_month}/${paymentData.card_expiry_year.slice(-2)}`; // Format as MM/YY

  // Security Code
  // const securityCodeInput = document.querySelector('input[name="payment_securityCode"]');
  // securityCodeInput.value = "XXX";
  const Amount = document.querySelector('input[name="payment_amount"]');
  Amount.value = `${paymentData.order_amount}(${paymentData.order_currency})`;
}

const handleCardTypeFromResponse=()=>{
  const formData = new FormData(document.getElementById("application"));
  if(responsePayment){
    const extract= JSON.parse(responsePayment?.response_json)
    const cardType= extract?.sourceOfFunds?.provided?.card?.brand
    if(Number(formData.get('Payment_Mode'))===1001){
      if(cardType==="MASTERCARD"){
        return 2
      }else if (cardType==="VISA"){
        return 1
      }else if (cardType==="AMEX"){
        return 23
      }
    }else if(Number(formData.get('Payment_Mode'))===124){
      if(cardType==="MASTERCARD"){
        return 10
      }else if (cardType==="VISA"){
        return 9
      }else if (cardType==="AMEX"){
        return 26
      }
    }else if(Number(formData.get('Payment_Mode'))===122){
      return Number(formData.get('cardType'))
    }

  }
}