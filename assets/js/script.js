document.addEventListener('DOMContentLoaded', function() {
    var readMoreToggles = document.querySelectorAll('.compadoReadMoreToggle'); // Use class selector

    readMoreToggles.forEach(function(toggle) {
        var targetId = toggle.getAttribute('data-target');
        var hiddenContainer = document.getElementById(targetId);
        hiddenContainer.style.maxHeight = '0'; // Ensure that container is closed initially.

        toggle.addEventListener('click', function() {
            if (hiddenContainer.style.maxHeight !== '0px') {
                hiddenContainer.style.maxHeight = '0';
                this.innerHTML = 'Read More <i class="fa fa-chevron-down"></i>';
            } else {
                hiddenContainer.style.maxHeight = hiddenContainer.scrollHeight + 'px';
                this.innerHTML = 'Read Less <i class="fa fa-chevron-up"></i>';
            }
        });
    });
});
