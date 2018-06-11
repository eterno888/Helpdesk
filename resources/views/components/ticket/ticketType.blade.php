<!-- Контент для заявки в произвольной форме -->
@if( ($ticketType->id) === 1)
    <tr>
        <td>{{ __('ticket.description')         }}:</td>
        <td><textarea name="body[]" required></textarea></td>
    </tr>
    @include('components.assignTeamField')
@endif

<!-- Контент для заявки на заправку картриджа -->
@if( ($ticketType->id) === 2)
    <tr>
        <td class="w40">Наименование тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Производитель тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Модель тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Инвентарный номер тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Серийный номер тех. единицы:</td>
        </td>
        <td class="w100"><input type="text" name="body[]" class="w100"></td>
    </tr>
@endif


<!-- Контент для заявки на ремонт компьтерной техники -->
@if( ($ticketType->id) === 3)
    <tr>
        <td class="w40">Наименование тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Производитель тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Модель тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Инвентарный номер тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Серийный номер тех. единицы:</td>
        </td>
        <td class="w100"><input type="text" name="body[]" class="w100"></td>
    </tr>
    <tr>
        <td>{{ __('ticket.description')         }}:</td>
        <td><textarea name="body[]" required></textarea></td>
    </tr>
@endif


<!-- Контент для заявки на ремонт офисной техники -->
@if( ($ticketType->id) === 4)
    <tr>
        <td class="w40">Наименование тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Производитель тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Модель тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Инвентарный номер тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Серийный номер тех. единицы:</td>
        </td>
        <td class="w100"><input type="text" name="body[]" class="w100"></td>
    </tr>
    <tr>
        <td>{{ __('ticket.description')         }}:</td>
        <td><textarea name="body[]" required></textarea></td>
    </tr>
@endif

<!-- Контент для заявки на регистрацию пользователей в сети -->
@if( ($ticketType->id) === 5)
    <tr>
        <td class="w40">Фамилия И.О. в латинской транскрипции:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Пароль (не менее 6 символов):</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
@endif

<!-- Контент для заявки на мультимедийное сопровождение -->
@if( ($ticketType->id) === 6)
    <tr>
        <td class="w20">Наименование тех. единицы:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Дата:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
    <tr>
        <td>Время:</td>
        <td class="w100"><input type="text" name="body[]" class="w100" required></td>
    </tr>
@endif
