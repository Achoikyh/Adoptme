document.addEventListener('scroll', () => {
    const header = document.querySelector('.header-main');
    if (window.scrollY > 0) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

document.addEventListener('scroll', () => {
    const navLinks = document.querySelectorAll('#navbar li a');
    navLinks.forEach(link => {
        if (window.scrollY > 0) {
            link.classList.add('scrolled');
        } else {
            link.classList.remove('scrolled');
        }
    });
});

const listItems = document.querySelectorAll(".sidebar-accordion-menu");
const submenuItems = document.querySelectorAll(".sidebar-submenu-category-list");

listItems.forEach((item, index) => {
  item.addEventListener("click", () => {
    const isActive = item.classList.contains('active');

    // Close all other submenu items
    submenuItems.forEach((submenuItem, i) => {
      if (i !== index) {
        submenuItem.classList.remove('active');
        listItems[i].classList.remove('active');
      }
    });

    // Toggle 'active' class on clicked accordion menu item
    item.classList.toggle("active");

    // Toggle 'active' class on the corresponding submenu item
    submenuItems[index].classList.toggle("active");
  });
});
'use strict';

// modal variables
const modal = document.querySelector('[data-modal]');
const modalCloseBtn = document.querySelector('[data-modal-close]');
const modalCloseOverlay = document.querySelector('[data-modal-overlay]');

// modal function
const modalCloseFunc = function () { modal.classList.add('closed') }

// modal eventListener
modalCloseOverlay.addEventListener('click', modalCloseFunc);
modalCloseBtn.addEventListener('click', modalCloseFunc);




// notification toast variables
const notificationToast = document.querySelector('[data-toast]');
const toastCloseBtn = document.querySelector('[data-toast-close]');

// notification toast eventListener
toastCloseBtn.addEventListener('click', function () {
  notificationToast.classList.add('closed');
});


const openBtn = document.querySelector('.nav-open-btn');
const nav = document.querySelector('.header2');
const closeBtn = document.querySelector('.nav-close-btn'); // Assuming you have a separate close button

if (openBtn) {
    openBtn.addEventListener('click', () => {
        nav.classList.add('active');
    });
}

if (closeBtn) {
    closeBtn.addEventListener('click', () => {
        nav.classList.remove('active');
    });
}



