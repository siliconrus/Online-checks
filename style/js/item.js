
/* Учусь работать с JS */

let itemNumber = 1;

$('#addProduct').click(function (event) {

    if (itemNumber >= 5)
    {
        alert('По протоколу ATOL API можно добавить не больше 100 товаров! Во время тестов 5')
    } else {
        addDynamicExtraField();
    }
    return false;
});
function addDynamicExtraField() {
    ++itemNumber;
    //console.log(itemNumber)

    let product = `
            <th scope="row">${itemNumber}</th>
                        <td><input type="text" class="form-control" name="item${itemNumber}_field_1" id="address" placeholder="iPhone" required></td>
                        <td><input type="text" class="form-control" name="item${itemNumber}_field_2" id="address" placeholder="500" required></td>
                        <td><input type="text" class="form-control" name="item${itemNumber}_field_3" id="address" placeholder="3" required></td>
                        <td><input type="text" class="form-control" name="item${itemNumber}_field_4" id="address" placeholder="1500" required></td>
                        <td><select class="custom-select d-block w-100" name="item${itemNumber}_field_5" id="country" required>
                                <option value="99" selected disabled>Выберите</option>
                                <option value="0">Без НДС</option>
                                <option value="1">Ставка НДС 0%</option>
                                <option value="10">Ставка НДС 10%</option>
                                <option value="20">Ставка НДС 20%</option>
                                <option value="120">Ставка НДС расч. 20/120</option>
                                <option value="110">Ставка НДС расч. 10/110</option>
                            </select>
                                <div class="invalid-feedback">Please select a valid country.</div>
                        </td>
                        <td><select class="custom-select d-block w-100" id="state" name="item${itemNumber}_field_6" required>
                                <option value="" selected disabled>Выберите</option>
                                <option value="1">Товар</option>
                                <option value="2">Подакцизный товар</option>
                                <option value="3">Работа</option>
                                <option value="4">Услуга</option>
                                <option value="5">Ставка азартной игры</option>
                                <option value="6">Лотерейный билет</option>
                                <option value="7">Выигрыш лотереи</option>
                                <option value="8">Предоставление РИД</option>
                                <option value="9">Платёж</option>
                                <option value="10">Агентское вознаграждение</option>
                                <option value="11">Выигрыш азартной игры</option>
                                <option value="12">Составной предмет расчёта</option>
                                <option value="13">Иной предмет расчёта</option>
                            </select>
                                <div class="invalid-feedback">Please provide a valid state.</div>
                        </td>
                        <td><select class="custom-select d-block w-100" id="state" name="item${itemNumber}_field_7" required>
                                <option value="99" selected disabled>Выберите</option>
                                <option value="1">Полный расчёт</option>
                                <option value="2">Предоплата</option>
                                <option value="3">Аванс</option>
                                <option value="4">Частичный расчёт и кредит</option>
                                <option value="5">Предоплата 100%</option>
                                <option value="6">Передача в кредит</option>
                                <option value="7">Оплата кредита</option>
                            </select>
                                <div class="invalid-feedback">Please select a valid country.</div>
                        </td>
     `;

    let addProducts = document.getElementById('goodsTable');
    addProducts.insertRow(itemNumber).innerHTML = product;
}

$('#deleteProduct').click(function (event) {
    if (itemNumber > 1)
    {
        document.getElementById('goodsTable').deleteRow(itemNumber);
        --itemNumber;
    }
    return false;
});

$('#sessionDestroy').click(function () {
    document.location.replace('/api/')
});

/* Запрос на сервер */

const myForm = document.getElementById('sendRequest');

myForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('apiBusiness.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(response => alert(response))
        .catch(error => console.error(error))
});

/* Старая версия отправки чеков через JSON */
$("document").ready(function() {
    $('#printCheck').on('click', function (e) {
        e.preventDefault();
        email = $('#JSONcheck').val();
        submit = $('#printCheck').attr('id');
        arrData = {email: email, submit: submit};

        $.ajax({
            url: "apiBusiness.php",
            method: "POST",
            //dataType: "json",
            data: arrData,
            success: function (data) {
                try {
                    alert(data)

                } catch(e) {
                    alert("JS Error:", e)
                }
            },
        });
    });
});