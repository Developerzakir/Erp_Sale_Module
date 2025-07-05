document.addEventListener('DOMContentLoaded', function() {
    let index = 1;

    // Add item
    document.getElementById('add-item').addEventListener('click', function() {
        let tbody = document.querySelector('#items-table tbody');
        let firstRow = tbody.querySelector('tr'); 
        let clone = firstRow.cloneNode(true);

        // Update names
        clone.querySelectorAll('input, select').forEach(el => {
            if(el.name) {
                el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
            }
            if(el.classList.contains('quantity')) el.value = 1;
            if(el.classList.contains('price')) el.value = '';
            if(el.classList.contains('discount')) el.value = 0;
        });
        clone.querySelector('.item-total').innerText = '0';

        tbody.appendChild(clone);
        index++;
    });

    // Remove item
    document.querySelector('#items-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('tr').remove();
        }
    });

    // Auto calculate
    document.querySelector('#items-table').addEventListener('input', function(e) {
        if(['quantity','price','discount'].some(c => e.target.classList.contains(c))) {
            calculateRowTotal(e.target.closest('tr'));
            calculateGrandTotal();
        }
    });

  
    // product select change হলে price update করা
document.querySelector('#items-table').addEventListener('change', function(e) {
    if (e.target.classList.contains('product-select')) {
        let price = e.target.selectedOptions[0].getAttribute('data-price') || 0;
        e.target.closest('tr').querySelector('.price').value = price;
        calculateRowTotal(e.target.closest('tr'));
        calculateGrandTotal();
    }
});

// Page load এ প্রথম row গুলোর জন্য price set করা
function setInitialPrices() {
    document.querySelectorAll('.product-select').forEach(function(select) {
        let price = select.selectedOptions[0].getAttribute('data-price') || 0;
        select.closest('tr').querySelector('.price').value = price;
        calculateRowTotal(select.closest('tr'));
    });
    calculateGrandTotal();
}

    // page load এ কল করো
    window.addEventListener('DOMContentLoaded', function() {
        setInitialPrices();
    });

    function calculateRowTotal(row) {
        let qty = parseFloat(row.querySelector('.quantity').value) || 0;
        let price = parseFloat(row.querySelector('.price').value) || 0;
        let discount = parseFloat(row.querySelector('.discount').value) || 0;
        let total = (qty * price) - discount;
        row.querySelector('.item-total').innerText = total.toFixed(2);
    }

    function calculateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.item-total').forEach(cell => {
            total += parseFloat(cell.innerText) || 0;
        });
        let grand = document.getElementById('grand-total');
        if(grand) grand.innerText = total.toFixed(2);
    }

    // Submit form via AJAX
    // document.getElementById('sale-form').addEventListener('submit', function(e) {
    //     e.preventDefault();
    //     let formData = new FormData(this);

    //     fetch('/sales', {
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    //         },
    //         body: formData
    //     })
    //     .then(res => res.json())
    //     .then(data => {
    //         alert(data.message);
    //         location.reload();
    //     })
    //     .catch(err => {
    //         alert('Error: ' + err);
    //     });
    // });

    document.getElementById('sale-form').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/sales', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'  // এই লাইনটা যোগ করো
        },
        body: formData
    })
    .then(res => {
        if (!res.ok) throw res;  // error হলে catch এ যাবে
        return res.json();
    })
    .then(data => {
        alert(data.message);
        location.reload();
    })
    .catch(async err => {
        if (err.status === 422) {
            const errorData = await err.json();
            let messages = Object.values(errorData.errors).flat().join("\n");
            alert("Validation errors:\n" + messages);
        } else {
            alert('Error: ' + err.statusText || err.status);
        }
    });
});




});