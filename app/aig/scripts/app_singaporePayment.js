function handlePaymentFrequencyChange(radio) {
  console.log("handlePaymentFrequencyChange");

  const paymentFrequency = radio.value;
  const paymentModeSelect = document.querySelector('select[name="Payment_Mode"]');
  // const paymentCardTypeSelect = document.querySelector('select[name="Payment_CardType"]');

  paymentModeSelect.value = ""; // Reset the dropdown
  // paymentCardTypeSelect.value="";
  const options = paymentModeSelect.options;

  for (let i = 0; i < options.length; i++) {
    const option = options[i];

    // If payment frequency is 2 and payment mode is '1001'
    if (paymentFrequency === '2' && option.value === '1001') {
      option.hidden = true;
    } else {
      option.hidden = false;
    }
  }

  const paymentMode = paymentModeSelect.value;
  // fetchPaymentOption(paymentMode, paymentFrequency);
}

function handlePaymentModeChange(select) {
  const paymentMode = select.value;
  const paymentFrequency = document.querySelector('input[name="Payment_Frequency"]:checked').value;
  // fetchPaymentOption(paymentMode, paymentFrequency)

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
const handlePaymentGateway = () => {
  if (quotationData?.premiumPayable) {
    const url = `payment.php?amount=${quotationData?.premiumPayable}`;
    window.open(url, 'childWindow', 'width=600,height=480');
  } else {
    console.log("no price", quotationData?.premiumPayable)
  }
};
function showAlert(message) {
  alert(message);

  setTimeout(() => {
    window.location.reload();

  }, 5000)
}