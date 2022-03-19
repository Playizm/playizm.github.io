// Set the date we're counting down to
var countDownDate = new Date("<?php echo date('Y/m/d').' '.$iftar; ?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    document.getElementById("clock").innerHTML = "<span id='tire'><?php echo replace_en(ucwords($city)); ?></span> <span class='text-1'>için İftara Kalan Süre:</span> <br /><span class='remaining'>" + hours + " saat "
    + minutes + " dakika " + seconds + " saniye </span>";
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("clock").innerHTML = "<img src='assest/img/mosque.png'> <br/> İftar açılmıştır. Hayırlı iftarlar!";
    }
}, 1000);