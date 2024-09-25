function handlePaymentFrequencyChange(radio) {
  console.log("handlePaymentFrequencyChange");

  const paymentFrequency = radio.value;
  const paymentModeSelect = document.querySelector('select[name="Payment_Mode"]');
  paymentModeSelect.value = "";
  const options = paymentModeSelect.options;
  for (let i = 0; i < options.length; i++) {
    const option = options[i];

    if (paymentFrequency === '2' && option.value === '1001') {
      option.hidden = true;
    } else {
      option.hidden = false;
    }
  }

  setPlanPoiValue(paymentFrequency);
}

function setPlanPoiValue(paymentFrequency) {
  const planPoi = document.querySelector('select[name="planPoi1"]');

  if (paymentFrequency === '1') { // Annual
    planPoi.value = "12";
  } else if (paymentFrequency === '2') { // Monthly
    planPoi.value = "1";
  } else {
    planPoi.value = "";
  }

  console.log("planPoi value set to:", planPoi.value);
}


function fetchPaymentOption(paymentMode, paymentFrequency) {
  if (!paymentMode || !paymentFrequency) return;

  const url = `../scripts/get_payment_option.php?payment_mode=${paymentMode}&payment_frequency=${paymentFrequency}`;
  document.body.classList.add('loading');

  fetch(url)
    .then(response => response.json())
    .then(data => {
      const cardTypeSelect = document.querySelector('select[name="Payment_CardType"]');

      cardTypeSelect.innerHTML = `   <option value="">
                      <-- Please select an option -->
                    </option>`;

      data.forEach(item => {
        const cardOption = document.createElement('option');
        cardOption.value = item.id;
        cardOption.textContent = item.payment_mode_card_name;
        cardTypeSelect.appendChild(cardOption);
      });
      console.log("data:", data)
    })
    .catch(error => {
      console.error('Error fetching payment data:', error);
    })
    .finally(() => {
      document.body.classList.remove('loading');
    });
}
const handleRetrieveQuote = async () => {
  const objectRetrieve = {
    "channelType": "10",
    "idNo": quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.customerIdNo,
    "policyNo": quotationData?.quoteNo
  };

  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let is_firsttime = url.searchParams.get('is_firsttime');
  console.log("is_firsttime:", is_firsttime)

  if (is_firsttime === "1") {
    handlePaymentGateway();
  } else {
    const responseRetrieve = await fetchRetrieveQuote(objectRetrieve);
    console.log("responseRetrieve:", responseRetrieve);
    console.log("quotationData:", quotationData);
    
    if (!responseRetrieve) {
      alert("Quote Retrieval List Operation failed");
      return;
    }
    
    const { statusCode, quoteList } = responseRetrieve;
    if (statusCode !== "P00") {
      alert("Quote Retrieval failed. Please try again.");
      return;
    }
    
    // Extract quote details
    let data = quoteList?.[0]?.Policy;
    console.log("data:", data);
    
    const responseRetrievePlanId = data?.insuredList?.[0]?.planList?.[0]?.planId;
    const quotePlanId = quotationData?.insuredList?.[0]?.personInfo?.planInfo?.planId;
    
    const isMatchingPlanAndAmount = 
      parseFloat(data?.premiumPayable) === parseFloat(quotationData?.premiumPayable) &&
      parseInt(data?.productId) === parseInt(quotationData?.productId) &&
      parseInt(responseRetrievePlanId) === parseInt(quotePlanId);
    
    if (isMatchingPlanAndAmount) {
      // Same plan and amount, proceed with updating the quote
      await jQuery.agent.updateRetrieveQuote(data, id);
      console.log("Quote successfully updated");
      handlePaymentGateway();
    } else {
      alert("Product is not available. Please do a recalculation of the quote.");
    }
    
  }
};

const handlePaymentGateway = async () => {
  // Retrieve Quote
  const isRecurring = quotationData?.payment_mode === 124 ? 1 : 0;

  if (quotationData?.premiumPayable) {
    const url = `payment.php?amount=${quotationData?.premiumPayable}&is_recurring=${isRecurring}&quoteNo=${quotationData?.quoteNo}`;
    window.open(url, 'childWindow', 'width=600,height=480');
  } else {
    console.log("No price", quotationData?.premiumPayable);
  }
};


function showAlert(message) {
  alert(message);
  setTimeout(() => {
    window.location.reload();
  }, 2000)
}
