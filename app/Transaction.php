<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Transaction extends Model
{
	/**
	* This is the model class for table "Transaction".
	*
	* @property float      $sum
	* @property string     $date
	* @property integer    $category_id
	* @property integer    $group_id
	* @property integer    $article_id
	*
	**/
	public $timestamps = false;
	protected $fillable = [
		'sum',
		'date',
		'group_id',
		'category_id',
		'article_id',
	];

	public function group()
	{
		return $this->belongsTo('App\Group');
	}

	public function category()
	{
		return $this->belongsTo('App\Category');
	}

	public function article()
	{
		return $this->belongsTo('App\Article');
	}

	public $groupName, $categoryName;                       // stores names
	public $dateMin, $dateMax;
	public $dateMap = [];                                   // stores array of dates
	public $dateFromIndex = 0, $dateToIndex = 0;            // indexes from and to what date transactions add to db
	public $categoryCount = 0, $groupCount = 0,
		   $transactionCount = 0, $articleCount = 0;        // counts added instances

	/**
	 * Formats date from y/n/d to Y-m-d so it is suitable to database date format
	 *
	 * @param $date
	 *
	 * @return string
	 */
	public static function dateForm( $date )
	{
		$dateArr = explode('/', $date);
		if (count($dateArr) != 3) return null;

		return "20{$dateArr[2]}-{$dateArr[1]}-{$dateArr[0]}";
	}

	/**
	 * Identifies date range that should be listed and defines indexes of the dates
	 * so we can save items only in particular range
	 *
	 * @param Request $request
	 *
	 * @param $dateArray
	 */
	public function identifyDateRange( Request $request, $dateArray )
	{
		$dateArray = array_map('self::dateForm', $dateArray);
		$dateFrom = strtotime($request['date-from']);
		$dateTo = strtotime($request['date-to']);
		$this->dateMin = strtotime($dateArray[1]);
		$this->dateMax = strtotime($dateArray[count($dateArray) - 1]);


		if ( $dateFrom > $dateTo  ||
		     $dateTo < $this->dateMin ||
		     $dateFrom   > $this->dateMax
		) return;

		while ((strtotime($dateArray[$this->dateFromIndex]) < $dateFrom
	         || strtotime($dateArray[$this->dateFromIndex]) == null)
             && $this->dateFromIndex < (count($dateArray) - 1) )
			$this->dateFromIndex++;

		$this->dateToIndex = $this->dateFromIndex;
		while ((strtotime($dateArray[$this->dateToIndex]) < $dateTo
	         || strtotime($dateArray[$this->dateToIndex]) == null)
			 && $this->dateToIndex < (count($dateArray) - 1) )
			$this->dateToIndex++;
	}

	/**
	 * Defines if category/group/article exists and if yes returns its id, if not - creates and returns id too
	 *
	 * @param $instance
	 * @param $name
	 *
	 * @return mixed
	 */
	public function getInstanceId( $instance, $name )
	{
		$model = 'App\\'.ucfirst($instance);
		$item = $model::where('name', $name)->first();
		if ( is_null($item) ) {
			$model::create(['name' => $name]);
			$this->{$instance.'Count'}++;
			return DB::getPdo()->lastInsertId();

		} else {
			return $item->id;
		}
	}


	/**
	 * Removes category name and null values from row so we can combine it with sum row
	 *
	 * @param $row
	 *
	 * @return array
	 */
	public function rowTransform( &$row )
	{
		array_walk($row, function(&$key, $item) {
			if ($key == null || substr($key, -1) == '$')
				$key = $item;
		});
	}

	/**
	 * Checks and delete values in row without sum
	 * Also set appropriate date as key name
	 *
	 * @param $row
	 *
	 * @return array
	 */
	public function getValidTrans( $row )
	{
		$row[0] = null;
		$row = array_combine($this->dateMap, $row);
		$offset = $this->dateToIndex - $this->dateFromIndex + 1;
		$row = array_slice($row, $this->dateFromIndex, $offset);
		return array_filter($row);
	}
}
