<html>
<head>
    <title>Custom Form Kit</title>
</head>
<body>
<center>

<!-- Razorpay Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    function openRazorpay() {
        var options = {
            "key": "{{ env('RAZORPAY_KEY') }}",
            "amount": "{{ $orderData['amount'] }}",
            "currency": "INR",
            "name": "Your Company",
            "description": "Payment",
            "order_id": "{{ $orderId }}",
            "theme": {
                "color": "#528FF0"
            },
            "notes": {
                "testregnid": "{{ $testregnid }}",
                "UserFID": "{{ $UserFID }}",
                "tid": "{{ $tid }}"
            },
            "handler": function (response) {
                // Create a form to submit the data to the verify-payment route
                var form = document.createElement("form");
                form.method = "POST";
                form.action = "/verify-payment";

                // Add CSRF token
                var csrfInput = document.createElement("input");
                csrfInput.type = "hidden";
                csrfInput.name = "_token";
                csrfInput.value = "{{ csrf_token() }}";
                form.appendChild(csrfInput);

                // Add payment response data
                var fields = {
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_signature: response.razorpay_signature,
                    amount: "{{ $orderData['amount'] }}",
                    testregnid: "{{ $testregnid }}",
                    UserFID: "{{ $UserFID }}",
                    tid: "{{ $tid }}"
                };

                // Append all fields to the form
                for (var field in fields) {
                    if (fields.hasOwnProperty(field)) {
                        var input = document.createElement("input");
                        input.type = "hidden";
                        input.name = field;
                        input.value = fields[field];
                        form.appendChild(input);
                    }
                }

                document.body.appendChild(form);
                form.submit(); // Submit the form
            },
            "modal": {
                "ondismiss": function() {
                     window.location.href = "{{ route('reliable-report') }}";
                }
            }
        };

        var rzp = new Razorpay(options);
        rzp.open();
    }

    // Open Razorpay checkout when the page loads
    window.onload = openRazorpay;
</script>

</center>
</body>
</html>
