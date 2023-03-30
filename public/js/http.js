const importExcelUrl = 'import-excel';
const updateSpamMessageUrl = 'spam-messages';
const appJson = 'application/json';

/**
 * Upload excel file
 * **/
$('#import-excel-btn').click(function(event) {
    event.preventDefault();
    let formData = new FormData($('#form-excel')[0]);
    ajax(
        importExcelUrl, 'post', formData,
        function(percent){
            $('#import-excel-btn').text(percent + '%').prop('disabled', true);
        },
        function(result){
            if (result.status) {
                $('#import-excel').modal('hide');
                $('#import-excel-btn').prop('disabled', false).text('Chèn vào ứng dụng');
                $('#file-excel-input').val('');
                sAlert(result.status, 'Hoàn tất import excel !');
                setTimeout(function(){
                    location.reload();
                }, 2500);
            }
            else {
                sAlert(result.status, 'Có lỗi trong quá trình import !');
                $('#import-excel-btn').prop('disabled', false).text('Chèn vào ứng dụng');
            }
        }
    );
});

/**
 * Update spam messages
 * **/
$('.spam-message-input').change(function(){
    let id = $(this).attr('data-id');
    let content = $(this).val();
    let url = `${updateSpamMessageUrl}/${id}`;

    let contentItem = {
        'message' : content
    };

    ajax(url, 'put', JSON.stringify(contentItem),
        null,
        function (result) {
            sAlert(result.status, result.messages);
        },
        appJson
    );
});

/**
 * Update spam zalo customer
 * **/
$('.open-customer-zalo').click(function(){
    let _this = $(this);
    let id = $(this).attr('data-id');
    let zaloUrl = $(this).attr('data-zalo-url');
    let url = `customers/${id}/status`;
    let putData = JSON.stringify({
        'is_zalo_spamed' : true
    });

    ajax(url, 'put', putData,
        null,
        function(result) {
            if (result.status) {
                _this.text('Đã spam Zalo');
            } else {
                sAlert(false, result.messages);
            }
        },
        appJson
    );

    window.open(zaloUrl,'_blank');
});

/**
 * Update is_bad customer
 * **/
$('.set-status-is-bad').change(function() {
    let id = $(this).attr('data-id');
    let isBad = $(this).val();
    let url = `customers/${id}/status`;
    let putData = {
        'is_bad' : isBad
    };

    isBad == 0
        ? $(this).parent().parent().removeClass('opacity-0_7')
        : $(this).parent().parent().addClass('opacity-0_7')


    ajax(url, 'put', JSON.stringify(putData),
        null,
        function(result) {
            //sAlert(result.status, result.messages);
        },
        appJson
    );
});

/**
 * Update customer info
 * **/
let customerId = null;
$('.edit-customer').click(function() {
    customerId = $(this).attr('data-id');
    let url = `customers/${customerId}`;

    ajax(url, 'get', null, null, function (result) {
        $('#name').val(result.data.name);
        $('#phone').val(result.data.phone);
        $('#cccd').val(result.data.cccd);
        $('#address').val(result.data.address);
        $('#note').val(result.data.note);
    });
});
$('#update-customer-btn').click(function(){
    let url = `customers/${customerId}`;
    let customerData = {
        'name' : $('#name').val(),
        'phone' : $('#phone').val(),
        'cccd' : $('#cccd').val(),
        'address' : $('#address').val(),
        'note' : $('#note').val(),
    }

    ajax(url, 'put', JSON.stringify(customerData),
        function (percent) {
            console.log(percent);
        },
        function (result) {
            if (result.status) {
                sAlert(true, result.messages);
                $('#customer-note').modal('hide');
            } else {
                let messages = result.messages;
                let errors = ``;
                for(var field in messages){
                    errors += `<div>${messages[field]}</div>`;
                }
                sAlert(false, errors);
            }
        },
        appJson
    )
});

/**
 * Login
 * **/
$('#submit-login-form').click(function(){
    let formData = new FormData($('#form-login')[0]);
    let url = 'login';

    ajax(url, 'post', formData, null,
        function (result) {
            if (result.status) {
                window.location.href = 'dashboard';
            } else {
                $('.wrap-message span').text(result.messages);
            }
        }
    )
});

/**
 * Http ajax request to server
 * @param string url
 * @param string type
 * @param mixed data
 * @param function callback1
 * @param function callback2
 * @return void
 * **/
function ajax(url, method, data, processCallback, successCallback, contentType = false)
{
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': csrf
        },
        url: url,
        type: method,
        data: data,
        processData: false,
        contentType: contentType,
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    let percent = parseInt(evt.loaded * (100 / evt.total));
                    
                    if (processCallback) {
                        processCallback(percent);
                    }
                }
            }, false);
        
            return xhr;
        },
        success: function(result) {
            successCallback(result);
        }
    });
}

/**
 * Show alert
 * @param boolean status
 * @param string title
 * @return void
 * **/
function sAlert(status, title)
{
    Swal.fire({
        position: 'center',
        icon: status ? 'success' : 'error',
        title: title,
        showConfirmButton: false,
        timer: status ? 3000 : 5000
    });
}

$('#convert-button').click(function(){
    var lines = $('#before-convert').val().split('\n');
    let result = '';
    for(var i = 0; i < lines.length; i++){

      // For phone
      let phoneNumber = lines[i].replace(/\D/g, '');
      phoneNumber = phoneNumber.replace('.', '');
      phoneNumber = phoneNumber.trim();

      //For name
      let customerName = lines[i].replace(/[0-9]/g, '');
      customerName = customerName.replace('- [ ] ', '');
      customerName = customerName.replace('.', '');
      customerName = customerName.trim();

      if (phoneNumber != '') {
        result += customerName + '\t' + phoneNumber + '\n';
      }
    }

    $('#after-convert').val(result);
    navigator.clipboard.writeText(result);
});