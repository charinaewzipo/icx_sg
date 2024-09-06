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
    getDraftDataWithId: function (draftid) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: url,
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify({
            action: "getDraftDataWithId",
            draftid: draftid
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
    getPaymentLogWithId: function (policyid) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: url,
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify({
            action: "getPaymentLogWithId",
            policyid: policyid
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
    getPolicyCreateOrNot: function (policyid) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: url,
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify({
            action: "getPolicyCreateOrNot",
            policyid: policyid
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
    insertQuotationData: function (formData, response) {
      $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          action: "insertQuotation",
          formData: formData,
          response: response,
          type: selectedType
        }),
        dataType: "text",
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
    insertPolicyData: function (policyid, policyNo) {
      $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          action: "insertPolicy",
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
    insertDraftQuoteData: function (formData) {
      $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          action: "insertDraftQuoteData",
          formData: formData,
          type: selectedType
        }),
        dataType: "text",
        success: function (response) {
          console.log("Insert Response:", response);
          // Handle the response data here
          // window.location.reload();
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", error);
          // Handle the error here
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
    }
  };
})(jQuery);
