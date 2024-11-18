  <!-- Phần Slideshow -->
  <div class="slideshow-container">
    <div class="slides">
      <div class="mySlides">
        <img src="../Public/user/HinhAnhThuoc/nhung-kieu-toc-cua-hieuthuhai-tang-luc-hut-kho-cuong-cho-ban-1.webp" style="width:100%">
      </div>
      <div class="mySlides">
        <img src="../Public/user/HinhAnhThuoc/nhung-kieu-toc-cua-hieuthuhai-tang-luc-hut-kho-cuong-cho-ban-2.webp" style="width:100%">
      </div>
      <div class="mySlides">
        <img src="../Public/user/HinhAnhThuoc/nhung-kieu-toc-cua-hieuthuhai-tang-luc-hut-kho-cuong-cho-ban-3.webp" style="width:100%">
      </div>
      <div class="mySlides">
        <img src="../Public/user/HinhAnhThuoc/nhung-kieu-toc-cua-hieuthuhai-tang-luc-hut-kho-cuong-cho-ban-4.webp" style="width:100%">
      </div>
      <div class="mySlides">
        <img src="../Public/user/HinhAnhThuoc/nhung-kieu-toc-cua-hieuthuhai-tang-luc-hut-kho-cuong-cho-ban-5.webp" style="width:100%">
      </div>
    </div>
  </div>

  <!-- Dấu chấm điều hướng -->
  <div class="dot-container">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
    <span class="dot" onclick="currentSlide(4)"></span>
    <span class="dot" onclick="currentSlide(5)"></span>
  </div>

  <div id="dichvu" class="container py-5">
    <h2 class="text-center">Dịch Vụ Của Chúng Tôi</h2>
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="service-box">
          <img src="path/to/service-image1.jpg" alt="Service 1" class="img-fluid">
          <h4>Dịch Vụ 1</h4>
          <p>Miêu tả dịch vụ 1.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-box">
          <img src="path/to/service-image2.jpg" alt="Service 2" class="img-fluid">
          <h4>Dịch Vụ 2</h4>
          <p>Miêu tả dịch vụ 2.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-box">
          <img src="path/to/service-image3.jpg" alt="Service 3" class="img-fluid">
          <h4>Dịch Vụ 3</h4>
          <p>Miêu tả dịch vụ 3.</p>
        </div>
      </div>
    </div>
  </div>

  <div id="khuyenmai" class="container py-5">
    <h2 class="text-center">Tin Tức Khuyến Mãi</h2>
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="service-box">
          <img src="path/to/service-image1.jpg" alt="Khuyến Mãi 1" class="img-fluid">
          <h4>Khuyến Mãi 1</h4>
          <p>Miêu tả Khuyến Mãi 1.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-box">
          <img src="path/to/service-image2.jpg" alt="Khuyến Mãi 2" class="img-fluid">
          <h4>Khuyến Mãi 2</h4>
          <p>Miêu tả Khuyến Mãi 2.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-box">
          <img src="path/to/service-image3.jpg" alt="Khuyến Mãi 3" class="img-fluid">
          <h4>Khuyến Mãi 3</h4>
          <p>Miêu tả Khuyến Mãi 3.</p>
        </div>
      </div>
    </div>
  </div>

  <script>
 document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault(); // Ngừng sự kiện mặc định (không tải lại trang)

        // Lấy phần tử mà chúng ta muốn cuộn đến
        const targetElement = document.querySelector(this.getAttribute('href'));

        // Hàm cuộn mượt mà với tốc độ tùy chỉnh
        smoothScroll(targetElement);
    });
});

function smoothScroll(target) {
    const startPosition = window.scrollY || document.documentElement.scrollTop;
    const targetPosition = target.offsetTop;
    const offset = 70; // Điều chỉnh khoảng cách offset
    const distance = targetPosition - startPosition - offset;
    const duration = 800;

    let startTime = null;

    // Kiểm tra hướng cuộn (lên hoặc xuống)
    const scrollDirection = distance > 0 ? 'down' : 'up'; // Nếu distance dương => cuộn xuống, nếu âm => cuộn lên

    function animation(currentTime) {
        if (startTime === null) startTime = currentTime;
        const timeElapsed = currentTime - startTime;
        const run = easeInOut(timeElapsed, startPosition, distance, duration);
        window.scrollTo(0, run);

        // Nếu cuộn lên (scrolling up), điều chỉnh để cuộn cao hơn một chút
        if (scrollDirection === 'up' && timeElapsed < duration / 2) {
            window.scrollTo(0, run - 20); // Điều chỉnh offset khi cuộn lên (thêm 20px khi cuộn lên)
        }

        if (timeElapsed < duration) {
            requestAnimationFrame(animation);
        }
    }

    function easeInOut(t, b, c, d) {
        let time = t / (d / 2);
        if (time < 1) return (c / 2) * time * time + b;
        time--;
        return (-c / 2) * (time * (time - 2) - 1) + b;
    }

    requestAnimationFrame(animation);
}


  </script>



  <script>
    let slideIndex = 0;
    const slides = document.querySelector('.slides');
    const dots = document.getElementsByClassName('dot');

    function showSlides() {
      slideIndex++;
      if (slideIndex >= dots.length) { slideIndex = 0; }
      updateSlidePosition();
      setTimeout(showSlides, 2000); // Tự động chuyển slide sau mỗi 2 giây
    }

    function currentSlide(n) {
      slideIndex = n - 1;
      updateSlidePosition();
    }

    function updateSlidePosition() {
      slides.style.transform = `translateX(-${slideIndex * 100}vw)`;
      for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
      }
      dots[slideIndex].classList.add("active");
    }

    showSlides(); // Bắt đầu trình chiếu
  </script>