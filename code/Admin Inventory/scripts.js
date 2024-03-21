function showToast(type, productname) {
    var toastContainer = document.getElementById('toast-container');
    var toast = document.createElement('div');
    toast.className = 'toast ' + type;
    var message;
    switch (type) {
        case 'success':
            message = 'Success: Your action was successful.';
            break;
        case 'error':
            message = 'Error: An error occurred.';
            break;
        case 'warning':
            message = 'Sorry, ' + productname + ' is currently out of stock.';
            break;
        default:
            message = 'Notification';
            break;
    }
    toast.innerHTML = message + '<span class="close" onclick="dismissToast(this)">&times;</span>' +
                       '<div class="progress-bar"><div class="progress-bar-inner"></div></div>';

    toastContainer.appendChild(toast);

    setTimeout(function() {
        toast.classList.add('show');
        var progressBar = toast.querySelector('.progress-bar-inner');
        progressBar.style.width = '0%';
        setTimeout(function() {
            progressBar.style.width = '100%';
        }, 100);
    }, 100);

    setTimeout(function() {
        dismissToast(toast.querySelector('.close'));
    }, 5000);
}

function dismissToast(element) {
    var toast = element.parentNode;
    toast.classList.remove('show');
    setTimeout(function() {
        toast.remove();
    }, 300);
}
