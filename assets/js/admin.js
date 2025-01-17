// File that returns matricNumbers
showStudentMatricNumberSuggestionsFile = 'model/student/showMatricNumbers.php';

// File that returns matricNumbers for sale tab
showStudentMatricNumberSuggestionsForSaleTabFile = 'model/student/showMatricNumbersForSaleTab.php';

$(document).ready(function() {

    // Listen to MatricNumber text box in student details tab
    $('#studentDetailsStudentMatricNumber').keyup(function () {
        showSuggestions('studentDetailsStudentMatricNumber', showStudentMatricNumberSuggestionsFile, 'studentDetailsStudentMatricNumberSuggestionsDiv');
    });
    // Remove the MatricNumber suggestions dropdown in the student details tab
    // when user selects an item from it
    $(document).on('click', '#studentDetailsStudentMatricNumberSuggestionsList li', function () {
        $('#studentDetailsStudentMatricNumber').val($(this).text());
        $('#studentDetailsStudentMatricNumberSuggestionsList').fadeOut();
        getStudentDetailsToPopulate();
    });

    // Listen to StudentID text box in sale details tab
    $('#borrowDetailsStudentMatricNumber').keyup(function () {
        showSuggestions('borrowDetailsStudentMatricNumber', showStudentMatricNumberSuggestionsForSaleTabFile, 'borrowDetailsStudentMatricNumberSuggestionsDiv');
    });
    // Remove the StudentID suggestions dropdown in the sale details tab
    // when user selects an item from it
    $(document).on('click', '#saleDetailsMatricNumberSuggestionsList li', function () {
        $('#borrowDetailsStudentMatricNumber').val($(this).text());
        $('#saleDetailsMatricNumberSuggestionsList').fadeOut();
        getStudentDetailsToPopulateSaleTab();
    });

    // listen to approve button in borrow request history in admin tab
    $(document).on('click', '.approveBorrowRequestButton', function () {
        var row = this.parentNode.parentNode;
        bootbox.confirm('Are you sure you want to approve this request?', function (result) {
            if (result) {
                approveBorrowRequest(row);
            }
        });
    });

    $(document).on('click', '.rejectBorrowRequestButton', function () {
        var row = this.parentNode.parentNode;
        bootbox.confirm('Are you sure you want to reject this request?', function (result) {
            if (result) {
                rejectBorrowRequest(row);
            }
        });
    });

    $(document).on('click', '.itemLendOutButton', function () {
        var row = this.parentNode.parentNode;
        bootbox.confirm('Are you sure you have lent out the item?', function (result) {
            if (result) {
                itemLendOut(row);
            }
        });
    });

    $(document).on('click', '.itemReturnButton', function () {
        var row = this.parentNode.parentNode;
        var lendOutQuantity = row.querySelector(':nth-child(4)').textContent;
        //regex
        lendOutQuantity = lendOutQuantity.match(/(?<=\/)\d+/)[0];
        bootbox.prompt({
            title: 'Input the quantity of returned item:',
            inputType: 'number',
            callback: function (itemReturnQuantity) {
                if(Number(itemReturnQuantity) && Number(itemReturnQuantity) <= lendOutQuantity){
                    itemReturn(row, itemReturnQuantity);
                } else {
                    bootbox.alert('Invalid Input');
                }
            }
        });
    });

    $(document).on('click', '.itemCheckButton', function () {
        var row = this.parentNode.parentNode;
        var itemReturnedQuantity = row.querySelector(':nth-child(4)').textContent;
        itemReturnedQuantity = itemReturnedQuantity.match(/\d+(?=\/)/)[0];
        bootbox.prompt({
            title: 'Input the quantity of checked item:',
            inputType: 'number',
            callback: function (itemCheckQuantity) {
                if(Number(itemCheckQuantity) && Number(itemCheckQuantity) <= itemReturnedQuantity){
                    itemCheck(row, itemCheckQuantity);
                } else {
                    bootbox.alert('Invalid Input');
                }
            }
        });
    });
})

// Function to send studentID so that student details can be pulled from db
// to be displayed on student details tab
function getStudentDetailsToPopulate(){
    // Get the studentID entered in the text box
    var studentDetailsStudentMatricNumber = $('#studentDetailsStudentMatricNumber').val();

    // Call the populateItemDetails.php script to get item details
    // relevant to the itemNumber which the user entered
    $.ajax({
        url: 'model/student/populateStudentDetailsByMatricNumber.php',
        method: 'POST',
        data: {matricNumber:studentDetailsStudentMatricNumber},
        dataType: 'json',
        success: function(data){
            $('#studentDetailsStudentID').val(data.studentID);
            $('#studentDetailsStudentFullName').val(data.fullName);
            $('#studentDetailsStudentMobile').val(data.mobile);
            $('#studentDetailsStudentPassword').val(data.password);
            $('#studentDetailsStudentEmail').val(data.email);
            $('#studentDetailsStudentAddress').val(data.address);
            $('#studentDetailsStatus').val(data.status).trigger("chosen:updated");
            $('#studentDetailsStudentIdentification').val(data.identification);
        }
    });
}

// Function to send studentID so that student details can be pulled from db
// to be displayed on sale details tab
function getStudentDetailsToPopulateSaleTab(){
    // Get the studentID entered in the text box
    var borrowDetailsStudentMatricNumber = $('#borrowDetailsStudentMatricNumber').val();

    // Call the populateStudentDetailsByMatricNumber.php script to get student details
    // relevant to the studentID which the user entered
    $.ajax({
        url: 'model/student/populateStudentDetailsByMatricNumber.php',
        method: 'POST',
        data: {matricNumber:borrowDetailsStudentMatricNumber},
        dataType: 'json',
        success: function(data){
            //$('#saleDetailsStudentID').val(data.studentID);
            $('#borrowDetailsStudentName').val(data.fullName);
        }
    });
}

// function to approve borrow request for admin
function approveBorrowRequest(row){

    var borrowRequestID = row.firstChild.textContent;

    // Call the cancelBorrowRequest.php script
    if (borrowRequestID !== ''){
        $.ajax({
            url: 'model/lend/approveBorrowRequest.php',
            method: 'Post',
            data:{
                borrowRequestID:borrowRequestID,
            },
            dataType: 'text',
            success: function(data){
                if(data === 'successful'){
                    bootbox.alert('Borrow request No.' + borrowRequestID + ' has been approved. For further operation, please check in lend history panel.');
                } else if(data === 'no stock') {
                    bootbox.alert('This item has no stock.');
                } else if(data === 'not enough stock') {
                    bootbox.alert('This item does not have enough stock for this request.');
                } else if(data === 'student not exist') {
                    bootbox.alert('Request student not found in DB.');
                } else if(data === 'invalid item') {
                    bootbox.alert('No such item in DB.');
                }
            },
            complete: function(){
                searchTableCreator('borrowRequestDetailsTableDiv', borrowRequestDetailsSearchTableCreatorFile, 'saleDetailsTable');
                searchTableCreator('approvalHistoryDetailsTableDiv', approvalHistoryDetailsSearchTableCreatorFile, 'approvalHistoryDetailsTable');
                reportsTableCreator('saleReportsTableDiv',saleReportsSearchTableCreatorFile,'saleReportsTable');
            }
        });
    }
}

// function to reject borrow request for admin
function rejectBorrowRequest(row){

    var borrowRequestID = row.firstChild.textContent;

    // Call the cancelBorrowRequest.php script
    if (borrowRequestID !== ''){
        $.ajax({
            url: 'model/lend/rejectBorrowRequest.php',
            method: 'Post',
            data:{
                borrowRequestID:borrowRequestID,
            },
            dataType: 'text',
            success: function(data){
                if(data === 'successful'){
                    bootbox.alert('Borrow request No.' + borrowRequestID + ' You can check in lend history panel.');
                }
            },
            complete: function(){
                searchTableCreator('borrowRequestDetailsTableDiv', borrowRequestDetailsSearchTableCreatorFile, 'saleDetailsTable');
                searchTableCreator('approvalHistoryDetailsTableDiv', approvalHistoryDetailsSearchTableCreatorFile, 'approvalHistoryDetailsTable');
                reportsTableCreator('saleReportsTableDiv',saleReportsSearchTableCreatorFile,'saleReportsTable');
            }
        });
    }
}

// function to reject borrow request for admin
function itemLendOut(row){

    var borrowRequestID = row.firstChild.textContent;

    // Call the cancelBorrowRequest.php script
    if (borrowRequestID !== ''){
        $.ajax({
            url: 'model/lend/itemLendOut.php',
            method: 'Post',
            data:{
                borrowRequestID:borrowRequestID,
            },
            dataType: 'text',
            success: function(data){
                if(data === 'successful'){
                    bootbox.alert('You have lent out the item for borrow request No.' + borrowRequestID);
                }
            },
            complete: function(){
                searchTableCreator('borrowRequestDetailsTableDiv', borrowRequestDetailsSearchTableCreatorFile, 'saleDetailsTable');
                searchTableCreator('approvalHistoryDetailsTableDiv', approvalHistoryDetailsSearchTableCreatorFile, 'approvalHistoryDetailsTable');
                reportsTableCreator('saleReportsTableDiv',saleReportsSearchTableCreatorFile,'saleReportsTable');
            }
        });
    }
}

// function to record return item for admin
function itemReturn(row, itemReturnQuantity) {
    var borrowRequestID = row.firstChild.textContent;
    itemReturnQuantity = Number(itemReturnQuantity);
    console.log(itemReturnQuantity);
    // Call the cancelBorrowRequest.php script
    if (borrowRequestID !== ''){
        $.ajax({
            url: 'model/lend/itemReturn.php',
            method: 'Post',
            data:{
                borrowRequestID:borrowRequestID,
                itemReturnQuantity:itemReturnQuantity,
            },
            dataType: 'text',
            success: function(data){
                if(data === 'successful'){
                    bootbox.alert('You have received ' + itemReturnQuantity + ' items for borrow request No.' + borrowRequestID);
                }
            },
            complete: function(){
                searchTableCreator('borrowRequestDetailsTableDiv', borrowRequestDetailsSearchTableCreatorFile, 'saleDetailsTable');
                searchTableCreator('approvalHistoryDetailsTableDiv', approvalHistoryDetailsSearchTableCreatorFile, 'approvalHistoryDetailsTable');
                reportsTableCreator('saleReportsTableDiv',saleReportsSearchTableCreatorFile,'saleReportsTable');
            }
        });
    }
}

// function to record return item for admin
function itemCheck(row, itemCheckQuantity) {
    var borrowRequestID = row.firstChild.textContent;
    itemCheckQuantity = Number(itemCheckQuantity);
    console.log(itemCheckQuantity);
    // Call the cancelBorrowRequest.php script
    if (borrowRequestID !== ''){
        $.ajax({
            url: 'model/lend/itemCheck.php',
            method: 'Post',
            data:{
                borrowRequestID:borrowRequestID,
                itemCheckQuantity:itemCheckQuantity,
            },
            dataType: 'text',
            success: function(data){
                if(data === 'successful'){
                    bootbox.alert('You have checked ' + itemCheckQuantity + ' available items for borrow request No.' + borrowRequestID
                                  + ' The stock in item table has been updated.');
                }
            },
            complete: function(){
                searchTableCreator('borrowRequestDetailsTableDiv', borrowRequestDetailsSearchTableCreatorFile, 'saleDetailsTable');
                searchTableCreator('approvalHistoryDetailsTableDiv', approvalHistoryDetailsSearchTableCreatorFile, 'approvalHistoryDetailsTable');
                reportsTableCreator('saleReportsTableDiv',saleReportsSearchTableCreatorFile,'saleReportsTable');
            }
        });
    }
}