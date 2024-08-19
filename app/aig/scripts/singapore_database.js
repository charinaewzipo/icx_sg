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
          response: response
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
    insertPolicyData: function (data,response) {
      $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          action: "insertPolicy",
          data:data,
          response: response
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
