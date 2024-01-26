document.addEventListener('DOMContentLoaded', function() {
    var readMoreToggles = document.querySelectorAll('.compadoReadMoreToggle');

    readMoreToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var hiddenContainer = document.getElementById(targetId);
            var productId = this.getAttribute('data-product-id');
            var openButton = document.querySelector('.compado-plan-btn-open[data-product-id="' + productId + '"]');
            var closedButton = document.querySelector('.compado-plan-btn-closed[data-product-id="' + productId + '"]');
            var moreIconsElement = document.querySelector('.more-icons[data-product-id="' + productId + '"]');
            var additionalIcons = document.getElementById('additional-icons-' + productId);

            if (hiddenContainer.style.maxHeight === '0px' || !hiddenContainer.style.maxHeight) {
                hiddenContainer.style.maxHeight = hiddenContainer.scrollHeight + 'px';
                openButton.style.display = 'block';
                closedButton.style.display = 'none';
                this.innerHTML = 'Read Less <i class="fa fa-chevron-up"></i>';
                if (additionalIcons) {
                    additionalIcons.style.display = 'flex';
                    if (moreIconsElement) {
                        moreIconsElement.style.display = 'none';
                    }
                }
            } else {
                hiddenContainer.style.maxHeight = '0px';
                openButton.style.display = 'none';
                closedButton.style.display = 'block';
                this.innerHTML = 'Read More <i class="fa fa-chevron-down"></i>';
                if (additionalIcons) {
                    additionalIcons.style.display = 'none';
                    if (moreIconsElement) {
                        moreIconsElement.style.display = 'flex';
                    }
                }
            }
        });
    });

    var hiddenContainers = document.querySelectorAll('.compado-hidden-container');
    hiddenContainers.forEach(function(container) {
        if (!container.style.maxHeight) {
            container.style.maxHeight = '0px';
        }
    });

    function clickReadMoreToggle(productId) {
        var readMoreToggle = document.querySelector('.compadoReadMoreToggle[data-product-id="' + productId + '"]');
        if (readMoreToggle) {
            readMoreToggle.click();
        }
    }

    window.toggleAdditionalIcons = function(productId, moreIconElement) {
        var additionalIcons = document.getElementById('additional-icons-' + productId);
        if (additionalIcons.style.display === 'none') {
            additionalIcons.style.display = 'flex';
            moreIconElement.style.display = 'none';
            clickReadMoreToggle(productId);
        } else {
            additionalIcons.style.display = 'none';
            moreIconElement.style.display = 'flex';
            clickReadMoreToggle(productId);
        }
    }




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

        var readMoreToggle = document.querySelector('.compadoReadMoreToggle[data-product-id="' + productId + '"]');
        if (readMoreToggle && readMoreToggle.innerHTML.includes('Read More')) {
            readMoreToggle.click();
        }
    } else {
        additionalIcons.style.display = 'none';
        moreIconElement.style.display = 'flex';
    }
}