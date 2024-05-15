// Get all data-faq items
var faqItems = document.querySelectorAll("[data-faq]");

// Loop through each item
faqItems.forEach(function (item) {
  // Get the button in the item
  var button = item.querySelector("[data-faq-button]");

  // Get the content in the item
  var content = item.querySelector("[data-faq-content]");

  // Get plus an mninus icons
  var plusIcon = item.querySelector("[data-faq-plus]");
  var minusIcon = item.querySelector("[data-faq-minus]");

  // Fore each item add the hidden class to the content
  item.classList.contains("is-active")
    ? content.classList.remove("hidden")
    : content.classList.add("hidden");

  // Add click event listener to the button
  button.addEventListener("click", function () {
    // Toggle the active class on the item
    item.classList.toggle("is-active");

    // Toggle the plus and minus icons
    plusIcon.classList.toggle("hidden");
    minusIcon.classList.toggle("hidden");

    // Toggle the hidden class on the content
    content.classList.toggle("hidden");
  });
});
