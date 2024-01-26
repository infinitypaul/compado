document.addEventListener('DOMContentLoaded', function() {
    var readMoreToggles = document.querySelectorAll('.compadoReadMoreToggle');

    readMoreToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var hiddenContainer = document.getElementById(targetId);
            var productId = this.getAttribute('data-product-id');
            var openButton = document.querySelector('.compado-plan-btn-open[data-product-id="' + productId + '"]');
            var closedButton = document.querySelector('.compado-plan-btn-closed[data-product-id="' + productId + '"]');

            if (hiddenContainer.style.maxHeight === '0px' || !hiddenContainer.style.maxHeight) {
                hiddenContainer.style.maxHeight = hiddenContainer.scrollHeight + 'px';
                //hiddenContainer.style.maxHeight = '1500px';
                openButton.style.display = 'block';
                closedButton.style.display = 'none';
                this.innerHTML = 'Read Less <i class="fa fa-chevron-up"></i>';
            } else {
                hiddenContainer.style.maxHeight = '0px';
                openButton.style.display = 'none';
                closedButton.style.display = 'block';
                this.innerHTML = 'Read More <i class="fa fa-chevron-down"></i>';
            }
        });
    });

    var hiddenContainers = document.querySelectorAll('.compado-hidden-container');
    hiddenContainers.forEach(function(container) {
        if (!container.style.maxHeight) {
            container.style.maxHeight = '0px';
        }
    });




    var carousels = document.querySelectorAll('.compado-carousel');
    carousels.forEach(function(carousel) {
        var images = carousel.querySelectorAll('.img');
        var dots = carousel.querySelectorAll('.dot');

        function updateCarousel(index) {
            images.forEach(function(image, idx) {
                image.classList.toggle('active', index === idx);
            });
            dots.forEach(function(dot, idx) {
                dot.classList.toggle('active', index === idx);
            });
        }

        dots.forEach(function(dot, idx) {
            dot.addEventListener('click', function() {
                updateCarousel(idx);
            });
        });
    });
});

function toggleAdditionalIcons(productId, moreIconElement) {
    var additionalIcons = document.getElementById('additional-icons-' + productId);
    if (additionalIcons.style.display === 'none') {
        additionalIcons.style.display = 'flex';
        moreIconElement.style.display = 'none';
    } else {
        additionalIcons.style.display = 'none';
        moreIconElement.style.display = 'flex';
    }
}
