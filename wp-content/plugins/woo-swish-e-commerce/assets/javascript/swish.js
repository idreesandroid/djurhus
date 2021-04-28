var server_resp = { status: 'WAITING', message: swish.message }
function waitForPayment() {
  var data = {
    action: 'wait_for_payment',
    url: window.location.href,
    nonce: swish.nonce
  }
  jQuery.post(swish.ajaxurl, data, function (response) {
    server_resp = response
  })
  document.getElementById('swish-status').innerHTML = server_resp['message']

  if ((server_resp['status'] != 'WAITING')) {
    jQuery('.swish-loader').hide()
    document.getElementById('swish-logo-id').src = swish.logo
    return
  }

  setTimeout(function () { waitForPayment() }, 3000)
}

function waitForPaymentModal() {

  var modal = document.getElementById('swish-modal-id');
  modal.style.display = "block";
  jQuery('.swish-loader').show();

  var data = {
    action: 'wait_for_payment',
    url: window.location.href,
    nonce: swish.nonce
  }

  jQuery.post(swish.ajaxurl, data, function (response) {
    server_resp = response
  })

  var message = server_resp['message'];
  document.getElementById('swish-status').innerHTML = message;

  if ((server_resp['status'] != 'WAITING')) {

    if (server_resp['status'] == 'PAID') {
      jQuery('.woocommerce-thankyou-order-received').html(message)
    } else {
      jQuery('.woocommerce-thankyou-order-received').replaceWith(`<p class="alert-color woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">${message}</p>`)
    }

    var modal = document.getElementById('swish-modal-id');
    modal.style.display = "none";
    jQuery('.swish-loader').hide();
    return
  }
  setTimeout(function () { waitForPaymentModal() }, 1000)
}