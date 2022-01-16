function addtoday() {
 	              document.getElementById("todayform").style.display = "block";
        }
        function closetodayform() {
        	document.getElementById("todayform").style.display = "None";
        }
        function addnew() {
        	document.getElementById("newform").style.display = "block";
        }
        function closenewform() {
        	document.getElementById("newform").style.display = "None";
        }
        function uploadnew() {
        	alert("Data Uploaded to Database Successfully");
        }
        function showdate(id) {
        	alert(id);
        }
        function addtrade() {
                document.getElementById("tradeform").style.display = "block";
        }
        function closetrade() {
                document.getElementById("tradeform").style.display = "None";
        }
window.onscroll = function() {myFunction()};

// Get the header
var header = document.getElementById("myheader");

// Get the offset position of the navbar
var sticky = header.offsetTop;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}