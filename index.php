<html>
    <head>
    </head>

    <body>
      <form id="paymentForm">

        <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email-address" required />
        </div>

        <div class="form-group">
        <label for="amount">Amount</label>
        <input type="tel" id="amount" required />
        </div>

        <div class="form-group">
        <label for="first-name">First Name</label>
        <input type="text" id="first-name" />
        </div>

        <div class="form-group">
        <label for="last-name">Last Name</label>
        <input type="text" id="last-name" />
        </div>

        <div cl ass="form-submit">
        <button type="submit" onclick="payWithPaystack()"> Pay </button>
        </div>

      </form>
        
        <script src="https://js.paystack.co/v1/inline.js"></script>
        
        <script>
            const paymentForm = document.getElementById('paymentForm');
            paymentForm.addEventListener("submit", payWithPaystack, false);
            function payWithPaystack(e) {
            e.preventDefault();
            let handler = PaystackPop.setup({
            key: 'pk_test_ec685c0827ca46baaaa016b23193be9ca8587f8b', // Replace with your public key
            email: document.getElementById("email-address").value,
            firstname: document.getElementById("first-name").value,
            lastname: document.getElementById("last-name").value,
            amount: document.getElementById("amount").value * 100,
            reference: ''+Math.floor((Math.random() * 1000000000) + 1)+'', // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            // label: "Optional string that replaces customer email"
            onClose: function(){
              window.location = "index.php?transaction=cancel";
              alert('Transaction Cancelled');
            },
            callback: function(response){
            let message = 'Payment complete! Reference: ' + response.reference;
            alert(message);
            window.location = "verify_transaction.php?reference=" + response.reference;
            }
            });
            
            handler.openIframe();
}
        </script>
    
    <body>

</html>
