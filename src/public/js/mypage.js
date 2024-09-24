document.getElementById('updateButton').addEventListener('click', function() {
    // 各項目を取得
    let reservationDate = document.getElementById('reservationDate');
    let reservationTime = document.getElementById('reservationTime');
    let personNum = document.getElementById('personNum');

    // 内容をinputタグに変換
    reservationDate.innerHTML = `<input type="date" value="${reservationDate.textContent.trim()}">`;
    reservationTime.innerHTML = `<input type="time" value="${reservationTime.textContent.trim()}">`;
    personNum.innerHTML = `<input type="number" min="1" max="99" value="${parseInt(personNum.textContent.trim())}">`;

    // 編集ボタンを隠して保存ボタンを表示
    document.getElementById('updateButton').style.display = 'none';
    document.getElementById('saveButton').style.display = 'inline-block';
});

// document.getElementById('saveButton').addEventListener('click', function() {
//     // input要素の値を取得
//     let shopNameInput = document.getElementById('shopNameInput').value;
//     let reservationDateInput = document.getElementById('reservationDateInput').value;
//     let reservationTimeInput = document.getElementById('reservationTimeInput').value;
//     let personNumInput = document.getElementById('personNumInput').value;

//     // 元のtdタグに戻して値を反映
//     document.getElementById('shopName').textContent = shopNameInput;
//     document.getElementById('reservationDate').textContent = reservationDateInput;
//     document.getElementById('reservationTime').textContent = reservationTimeInput;
//     document.getElementById('personNum').textContent = personNumInput + '人';

//     // 保存ボタンを隠して編集ボタンを表示
//     document.getElementById('editButton').style.display = 'inline-block';
//     document.getElementById('saveButton').style.display = 'none';
// });
