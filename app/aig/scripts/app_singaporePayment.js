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
const handlePaymentGateway =async () => {
  //retrieve Quote 
  const objectRetrieve = {
    "channelType": "10",
    "idNo": quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.customerIdNo,
    "policyNo": quotationData?.quoteNo
  }
  const responseRetrieve = await fetchRetrieveQuote(objectRetrieve)
  console.log("responseRetrieve:", responseRetrieve)
  if (!responseRetrieve) {
    alert("Quote Retrieval List Operation failed");
  } else if (responseRetrieve?.statusCode === "P00") {
    isRecurring = quotationData?.payment_mode===124 ? 1:0;
  
  if (quotationData?.premiumPayable) {
    const url = `payment.php?amount=${quotationData?.premiumPayable}&is_recurring=${isRecurring}&quoteNo=${quotationData?.quoteNo}`;
    window.open(url, 'childWindow', 'width=600,height=480');
  } else {
    console.log("no price", quotationData?.premiumPayable)
  }
  }
  
  
};
function showAlert(message) {
  alert(message);
  setTimeout(()=>{
    window.location.reload();
  },2000)
}
