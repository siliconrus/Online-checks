<?php
session_start();
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Формирование чека Бизнес.Ру Онлайн-чеки</title>
    <!-- Bootstrap core CSS -->
    <link href="../style/css/bootstrap/bootstrap.css" rel="stylesheet">
    <script src="../style/js/jquery-3.4.1.min.js"></script>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="../style/css/bootstrap/form-validation.css" rel="stylesheet">
</head>
<body class="bg-light" style="margin-right: 300px;">
<div class="container">
    <div class="py-5 text-center" style="margin-left: 100px;width: 930px;"">
        <img class="d-block mx-auto mb-4" src="../style/css/bootstrap/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h2>Формирование чека Бизнес.Ру Онлайн-чеки через API</h2>
        <p class="lead">Здесь должна быть инструкция, но ее нет(</p>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Отправить JSON на печать</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <textarea rows="15" cols="62" id="JSONcheck" placeholder="Здесь указываем JSON чека.."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="printCheck" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3" style="margin-left: 310px;">Общая информация</h4>
            <form class="needs-validation" id="sendRequest" novalidate>
                <div class="row" style="margin-left: 310px;width: 500px;">
                    <div class="col-md-6 mb-3">
                        <label for="email">Ваш appID<span class="text-muted">(работает на сессиях)</span></label>
                        <input type="text" class="form-control" id="username"  name="appID"
                               value="<?=$_SESSION['appID']?>" placeholder="8dd25311-3e38-4ba9.." required>
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>
               <div class="col-md-6 mb-3">
                        <label for="email">Ваш secret <span class="text-muted">(работает на сессиях)</span></label>
                        <input type="text" class="form-control" id="username" name="secret"
                               value="<?=$_SESSION['secret']?>" placeholder='XPAZRYCJVf74dxwLOb..' required>
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email">Email <span class="text-muted">(Optional)</span></label>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder='example@siliconrus.ru' required>
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>

                    <div class="col-md-5 mb-3">
                        <label for="country">СНО</label>
                        <select class="custom-select d-block w-100" id="country" name="taxSystem" required>
                                <option value="">Не выбрано</option>
                                <option value="1">ОСН</option>
                                <option value="2">УСН (доход)</option>
                                <option value="3">УСН (доход - расход)</option>
                                <option value="4">ЕНВД</option><option value="5">ЕСХН</option>
                                <option value="6">ПСН</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid country.
                        </div>
                    </div>
                </div>
                <table class="table" id="goodsTable" style="width: 1100px; margin-right: 300px;">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Количество</th>
                        <th scope="col">Сумма</th>
                        <th scope="col">Ставка НДС</th>
                        <th scope="col">Предмет расчёта</th>
                        <th scope="col">Метод расчёта</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr><th scope="row">1</th>
                        <td><input type="text" class="form-control" name="item0_field_1" id="address" placeholder="iPhone" required></td>
                        <td><input type="text" class="form-control" name="item0_field_2" id="address" placeholder="500" required></td>
                        <td><input type="text" class="form-control" name="item0_field_3" id="address" placeholder="3" required></td>
                        <td><input type="text" class="form-control" name="item0_field_4" id="address" placeholder="1500" required></td>
                        <td><select class="custom-select d-block w-100" name="item0_field_5" id="country" required>
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
                        <td><select class="custom-select d-block w-100" id="state" name="item0_field_6" required>
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
                        <td><select class="custom-select d-block w-100" id="state" name="item0_field_7" required>
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
                    </tr>
                    </tbody>
                </table>
                <div class="mb-3" style="margin-left: 400px;margin-right: 0px;width: 500px;">
                <button type="button" class="btn btn-primary btn-sm" id="addProduct">Добавить товар</button>
                <button type="button" class="btn btn-secondary btn-sm" id="deleteProduct">Удалить товар</button>
                <button type="button" class="btn btn-secondary btn-sm"
                        data-toggle="modal" data-target="#exampleModal">Отправить JSON'ом</button>
                </div>

                <!-- Это блок с ИТОГО ПО ЧЕКУ -->

                <hr class="mb-4" style="margin-left: 250px;width: 610px;">
                <h4 class="mb-3" style="margin-left: 200px;width: 482px;">Итого по чеку</h4>

                <div class="row" style="margin-left: 200px;width: 700px;">
                    <div class="col-md-6 mb-3">
               <label for="username">Безналичными</label>
               <div class="input-group">
                   <div class="input-group-prepend">
                       <span class="input-group-text">₽</span>
                   </div>
                   <input type="text" class="form-control" name="payedCashless" placeholder="0.00" id="username" >
                   <div class="invalid-feedback" style="width: 100%;">
                       Your username is required.
                   </div>
               </div>
           </div>
                    <div class="col-md-6 mb-3">
                        <label for="username">Предоплатой (предыдущие платежи)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₽</span>
                            </div>
                            <input type="text" class="form-control" id="username"  name="payedPrepay" placeholder="0.00">
                            <div class="invalid-feedback" style="width: 100%;">
                                Your username is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="username">Постоплата (кредит)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₽</span>
                            </div>
                            <input type="text" class="form-control" id="username" name="payedNextcredit" placeholder="0.00">
                            <div class="invalid-feedback" style="width: 100%;">
                                Your username is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="username">Наличными</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₽</span>
                            </div>
                            <input type="text" class="form-control" id="username" name="payedCash" placeholder="0.00" >
                            <div class="invalid-feedback" style="width: 100%;">
                                Your username is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="username">Встречным предоставлением</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₽</span>
                            </div>
                            <input type="text" class="form-control" id="username" name="payedConsideration" placeholder="0.00" >
                            <div class="invalid-feedback" style="width: 100%;">
                                Your username is required.
                            </div>
                        </div>
                    </div>
                </div>
                <!-- КОНЕЦ БЛОКА ИТОГО ПО ЧЕКУ -->

            <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-sm">Малое модальное окно</button>

                <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            ...
                        </div>
                    </div>
                </div>-->

                <hr class="mb-4" style="margin-left: 235px;width: 610px;">
                <button class="btn btn-primary btn-lg btn-block" style="margin-left: 250px;" type="submit">Отправить чек на печать</button>
            </form>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small" style="margin-left: 310px;width: 800px;">
        <p class="mb-1" >&copy; 2017-2020 Company Name</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacy</a></li>
            <li class="list-inline-item"><a href="#">Terms</a></li>
            <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
    </footer>
</div>

<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
--><script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
<script src="../style/css/bootstrap/bootstrap.bundle.js"></script>
<script src="../style/css/bootstrap/form-validation.js"></script>


<script src="../style/js/item.js"></script>

<script>
    /* test */
 /*   if (document.getElementById('...').value !== '') {

    }*/
</script>

</body>
</html>
