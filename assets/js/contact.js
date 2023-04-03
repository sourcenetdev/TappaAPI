$(document).ready(function(){
function subscribe_newsletter() {
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>newsletter/subscribe",
        data: $("#subscribeForm").serialize(),
        success: function(data){
            d = JSON.parse(data);
            if (d.success) {
                swal("Thank you!", "You have been subscribed to our newsletter.", "success");
            } else {
                swal("A problem occurred", "There was an error subscribing you to our newsletter: \n" + d.message, "error");
            }
        }
    })
}

function unsubscribe_newsletter() {
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>newsletter/unsubscribe",
        data: $("#contactForm").serialize(),
        success: function(data) {
            d = JSON.parse(data);
            if (d.success) {
                swal("Thank you!", "You have been unsubscribed from our newsletter.", "success");
            } else {
                swal("A problem occurred", "There was an error unsubscribing you from our newsletter: \n" + d.message, "error");
            }
        }
    })
}

function submit_contact_form() {
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>contact/add_contact",
        data: $("#contactForm").serialize(),
        success: function(data) {
            d = JSON.parse(data);
            if (d.success) {
                swal("Thank you!", "Your message has been sent.", "success");
            } else {
                swal("A problem occurred", "There was an error sending your message: \n" + d.message, "error");
            }
        }
    })
}
});