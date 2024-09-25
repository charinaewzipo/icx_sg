(function ($) {
  var url = "outboundAIG.php";

  jQuery.agent = {
    getQuotationWithId: function (id) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: url,
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify({
            action: "getQuotationWithId",
            id: id
          }),
          dataType: "text",
          success: function (response) {
            try {
              const cleanedResponse = response.trim();
              const jsonResponse = JSON.parse(cleanedResponse);
              resolve(jsonResponse);
            } catch (error) {
              console.error("Error parsing JSON:", error);
              reject(error);
            }
          },
        });
      });
    },
    getPaymentLogWithId: function (quoteNo) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: url,
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify({
            action: "getPaymentLogWithId",
            quoteNo: quoteNo
          }),
          dataType: "text",
          success: function (response) {
            try {
              const cleanedResponse = response.trim();
              const jsonResponse = JSON.parse(cleanedResponse);
              resolve(jsonResponse);
            } catch (error) {
              console.error("Error parsing JSON:", error);
              reject(error);
            }
          },
        });
      });
    },
    insertQuotationData: function (formData, response, campaignDetails) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: url,
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify({
            action: "insertQuotation",
            formData: formData,
            response: response,
            type: selectedType,
            campaignDetails: campaignDetails
          }),
          dataType: "text",  // Set to "text" to manually handle parsing
          success: function (responseText) {
            // Trim the response to remove any unwanted characters
            const trimmedResponse = responseText.trim();

            try {
              // Parse the trimmed response as JSON
              const response = JSON.parse(trimmedResponse);
              console.log("Parsed Insert Response:", response);

              if (response.result === "success") {
                resolve(response.id);  // Resolve the promise with the inserted ID
              } else {
                reject("Error: " + response.message);  // Reject the promise if something goes wrong
              }
            } catch (e) {
              // Handle any parsing errors
              reject("Failed to parse JSON response: " + e.message);
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            reject(error);  // Reject the promise on AJAX error
          }
        });
      });
    },

    updatePolicyNo: function (policyid, policyNo) {
      $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          action: "updatePolicyNo",
          policyid: policyid,
          policyNo: policyNo
        }),
        dataType: "json",
        success: function (response) {
          console.log("Insert Response:", response);
          // Handle the response data here
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", error);
          // Handle the error here
        }
      });
    },

    updateRetrieveQuote: function (response, id) {
      $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          action: "updateRetrieveQuote",
          response: response,
          id: id
        }),
        dataType: "text",
        success: function (response) {
          try {
            var jsonResponse = JSON.parse(response.trim());  // Manually parse the JSON and remove extra spaces
            console.log("Insert Response:", jsonResponse);
            if (jsonResponse.result === "success") {
              // window.location.reload();
            }
          } catch (e) {
            console.error("JSON Parsing Error:", e, response);
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", error);
        }
      });
    },
    updateQuoteData: function (formData, response, id) {
      $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          action: "updateQuoteData",
          formData: formData,
          response: response,
          type: selectedType,
          id: id
        }),
        dataType: "text",
        success: function (response) {
          try {
            var jsonResponse = JSON.parse(response.trim());  // Manually parse the JSON and remove extra spaces
            console.log("Insert Response:", jsonResponse);
            if (jsonResponse.result === "success") {
              window.location.reload();
            }
          } catch (e) {
            console.error("JSON Parsing Error:", e, response);
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", error);
        }
      });
    },

    insertPaymentLog: function (request, response, policyid, objectPayment) {
      $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          action: "insertPaymentLog",
          request: request,
          response: response,
          policyid: policyid,
          objectPayment: objectPayment
        }),
        dataType: "json",
        success: function (response) {
          console.log("Insert Response:", response);
          // Handle the response data here
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", error);
          // Handle the error here
        }
      });
    },
    insertPaymentGatewayLog: function (policyid, response) {
      $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          action: "insertPaymentLog",
          response: response,
          policyid: policyid
        }),
        dataType: "json",
        success: function (response) {
          console.log("Insert Response:", response);
          // Handle the response data here
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", error);
          // Handle the error here
        }
      });
    }
  };
})(jQuery);
