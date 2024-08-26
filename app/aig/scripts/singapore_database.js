(function ($) {
  var url = "outboundAIG.php";

  jQuery.agent = {
    getQuotationWithId: function (policyid) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: url,
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify({
            action: "getQuotationWithId",
            policyid: policyid
          }),
          dataType: "text",
          success: function (response) {
            try {
              console.log("response",response)
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
              console.log("response",response)
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
          type:selectedType
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
    insertPolicyData: function (policyid,policyNo) {
      $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          action: "insertPolicy",
          policyid:policyid,
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
    insertPremiumData: function (data) {
      $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          action: "insertPremiumData",
          data:data
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
    insertPaymentLog: function (request,response,policyid) {
      $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          action: "insertPaymentLog",
          request:request,
          response:response,
          policyid:policyid
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
