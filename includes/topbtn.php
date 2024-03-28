
<style>
/* Style for the scroll to top button */

#scrollToTopBtn {
  display: none; /* Hidden by default */
  position: fixed; 
  bottom: 20px; 
  right: 20px; 
  z-index: 999; /* Ensure visibility on top */
  background-color: #007bff; 
  color: white; 
  border: none; 
  opacity: 0.7; /* Slightly transparent by default */
  cursor: pointer; 
  padding: 10px; /* Smaller padding for smaller screens */
  border-radius: 4px; /* Softer, less obtrusive corners */
}

/* Style for the scroll to top button on hover */
#scrollToTopBtn:hover {
  opacity: 1;  /* Fully opaque on hover */
}

/* Media query for smaller screens */
@media (max-width: 600px) {
  #scrollToTopBtn {
    bottom: 10px;
    right: 10px;
    padding: 8px; 
  }
}
body, html {
  overflow-x: hidden;
}

</style>


<button onclick="scrollToTop()" id="scrollToTopBtn" title="Go to top"><i class="fas fa-arrow-up"></i></button>




<script>
// Get the button
var scrollToTopButton = document.getElementById("scrollToTopBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {
  scrollFunction();
};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    scrollToTopButton.style.display = "block";
  } else {
    scrollToTopButton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' }); // Smooth scrolling 
}

</script>