document.addEventListener("DOMContentLoaded", function () {
    // Lấy tất cả các thẻ <a> trong menu
    const menuItems = document.querySelectorAll(".app-menu__item");
  
    // Kiểm tra URL hiện tại và thêm class active vào mục phù hợp
    const currentPath = window.location.pathname.split("/").pop();
    menuItems.forEach((item) => {
      if (item.getAttribute("href") === currentPath) {
        item.classList.add("active");
      } else {
        item.classList.remove("active");
      }
    });
  
    // Thêm sự kiện click vào mỗi mục menu
    menuItems.forEach((item) => {
      item.addEventListener("click", function (event) {
        // Xóa lớp 'active' khỏi tất cả các mục
        menuItems.forEach((i) => i.classList.remove("active"));
  
        // Thêm lớp 'active' vào mục được nhấp
        this.classList.add("active");
      });
    });
  });