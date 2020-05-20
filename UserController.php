<?php
  namespace App\Http\Controllers;
  use App\Http\Controllers\Controller;
  use Illuminate\Support\Facades\DB;

  class UserController extends Controller{

    public function index(){

      // вся таблица
      // Получите все записи из таблицы employees и выведите их в представлении в виде таблицы table.
      $users = DB::table('lara_employees')->get();

      // определённые стобцы
      // Модифицируйте предыдущую задачу так, чтобы запрос получал только поле с именем и поле с зарплатой работника.
      $users = DB::table('lara_employees')->select('name', 'salary')->get();

      // с условием
      // Из таблицы employees получите всех работников с зарплатой, не равной 500.
      $users = DB::table('lara_employees')->where('salary', '!=', 500)->get();

      // или
      // Из таблицы employees получите всех работников с зарплатой 400 или id, большем 4.
      $users = DB::table('lara_employees')->where('salary', '=', 400)->orWhere('id', '>', 4)->get();

      // получение 1й строки из таблицы
      // Из таблицы employees получите работника с id, равным 3.
      $users = DB::table('lara_employees')
      ->where('id', '=', 3)->first();

      // получение одного столбца
      // Из таблицы employees получите массив имен работников.
      $users = DB::table('lara_employees')->pluck('name');

      // дополнительные условия where, в интервале
      // Из таблицы employees получите работников, зарплата которых находится в промежутке от 450 до 1100.
      $users = DB::table('lara_employees')
      ->whereBetween('salary', [450, 1100])->get();

      // дополнительные условия where, в НЕ ИНТЕРВАЛА
      // Из таблицы employees получите работников, зарплата которых находится НЕ в промежутке от 300 до 600.
      $users = DB::table('lara_employees')
      ->whereNotBetween('salary', [300, 600])->get();

      // Фильтрация по совпадению с массивом значений
      // Из таблицы employees получите работников с id, равными 1, 2, 3 и 5.
      $users = DB::table('lara_employees')
      ->whereIn('id', [1,2,3,5])->get();

      //Метод whereNotIn() проверяет, что значения столбца не содержатся в данном массиве:
      // Из таблицы employees получите работников с id, НЕ равными 1, 2, 3.
      $users = DB::table('lara_employees')->whereNotIn('id', [1,2,3])->get();

      // Группировка условий
      // Из таблицы employees получите работников, у которых id от 1 до 3, либо зарплата от 400 до 800.

      $users = DB::table('lara_employees')
      ->whereBetween('id', [1,3])
      ->orWhere(function ($query){
        $query->where('salary', '>=', 400)
        ->where('salary', '<=', 400);
      })->get();

      // Динамические условия WHERE
      // выбрать должность программист ИЛИ с зп 500
      // or - или
      $users = DB::table('lara_employees')
      ->whereSalaryOrPosition(500, 'программист')
      ->get();

      // выбрать должность программист И с зп 500
      // and - И
      $users = DB::table('lara_employees')
      ->wherePositionAndSalary('программист', 500)
      ->get();

      // Метод whereColumn
      // Из таблицы events получите мероприятия, у которых дата начала и дата конца приходится на один и тот же день.
      $users = DB::table('lara_events')
      ->whereColumn('start', 'finish')
      ->get();

      // сортировка
      // Из таблицы employees получите всех работников и отсортируйте их по возрастанию зарплаты.
      $users = DB::table('lara_employees')
      ->orderBy('salary', 'asc')
      ->get();

      // $users = DB::table('lara_employees')
      // Из таблицы employees получите всех работников и отсортируйте их по убыванию даты рождения.
      ->orderBy('birthday', 'asc')
      ->get();

      // Агрегатные функции
      // Из таблицы employees получите максимальную зарплату.
      $users = DB::table('lara_employees')
      ->max('salary');

      // Из таблицы employees получите суммарную зарплату всех работников.
      $users = DB::table('lara_employees')
      ->sum('salary');

      // Группировка groupBy
      // Из таблицы employees для каждой должности получите минимальную зарплату.
      $users = DB::table('lara_employees')
      ->select('position', DB::raw('MIN(salary) as salary'))
      ->groupBy('position')
      ->orderBy('salary', 'asc')
      ->get();


      // Из таблицы employees для каждой должности получите суммарную зарплату.
      $users = DB::table('lara_employees')
      ->select('position', DB::raw('SUM(salary) as salary'))
      ->groupBy('position')
      ->orderBy('salary', 'asc')
      ->get();


      // Дата
      // Из таблицы employees получите работника, у которого день рождения приходится на дату 1988-03-25.
      $users = DB::table('lara_employees')
      ->whereDate('birthday', '1988-03-25')
      ->get();

      // Из таблицы employees получите работников, у которых день рождения приходится на 25 день месяца.
      $users = DB::table('lara_employees')
      ->whereDay('birthday', '25')
      ->get();

      // Из таблицы employees получите работников, у которых день рождения в марте.
      $users = DB::table('lara_employees')
      ->whereMonth('birthday','3')
      ->get();


      // Из таблицы employees получите работников, родившихся в 1990 году.
      $users = DB::table('lara_employees')
      ->whereYear('birthday', 1990)
      ->get();


      return view('user.index', [
        'users' => $users,
      ]);
    }
  }
