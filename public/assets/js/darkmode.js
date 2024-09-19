const themeSwitch = document.getElementById('theme-switch');
const themeSwitchMoon = document.getElementById('theme-switch-moon');
const themeSwitchSun = document.getElementById('theme-switch-sun');
// themeSwitch.addEventListener('change', function() {
//   if (this.checked) {
//     // Set dark mode
//     // document.body.classList.add('dark-mode');
//     localStorage.setItem('theme', 'dark');
//     document.cookie = "theme=dark;expires=Thu, 01 Jan 2099 00:00:00 UTC;path=/";
//   } else {
//     // Set light mode
//     document.body.classList.remove('dark-mode');
//     localStorage.setItem('theme', 'light');
//     document.cookie = "theme=light;expires=Thu, 01 Jan 2099 00:00:00 UTC;path=/";
//   }
// });

// // Apply theme preference on page load
if (localStorage.getItem('theme') === 'dark') {
    themeSwitchMoon.style.display = 'none';
    themeSwitchSun.style.display = 'block';
  // Set dark mode
//   document.body.classList.add('dark-mode');
  themeSwitch.checked = true;
} else {
    themeSwitchMoon.style.display = 'block';
    themeSwitchSun.style.display = 'none';
  // Set light mode
//   document.body.classList.remove('dark-mode');
  themeSwitch.checked = false;
}

// Check if cookie exists and set the theme accordingly
if (getCookie("theme")) {
  if (getCookie("theme") === 'dark') {
    themeSwitchMoon.style.display = 'none';
    themeSwitchSun.style.display = 'block';
    // document.body.classList.add('dark-mode');
    themeSwitch.checked = true;
  } else {
    themeSwitchMoon.style.display = 'block';
    themeSwitchSun.style.display = 'none';
    // document.body.classList.remove('dark-mode');
    themeSwitch.checked = false;
  }
}
// const toggleDarkMode = () => {
//     // var value = $(this).val();
//     alert();
// };


themeSwitchMoon.addEventListener('click', function(){
    // Set dark mode
    // document.body.classList.add('dark-mode');
    localStorage.setItem('theme', 'dark');
    document.cookie = "theme=dark;expires=Thu, 01 Jan 2099 00:00:00 UTC;path=/";
    location.reload();
});
themeSwitchSun.addEventListener('click', function(){
    // Set light mode
    localStorage.setItem('theme', 'light');
    document.cookie = "theme=light;expires=Thu, 01 Jan 2099 00:00:00 UTC;path=/";
    location.reload();
});



// Helper function to get cookie value by name
function getCookie(name) {
  const value = "; " + document.cookie;
  const parts = value.split("; " + name + "=");
  if (parts.length === 2) return parts.pop().split(";").shift();
}
