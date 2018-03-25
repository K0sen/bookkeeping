<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Category;
use App\Group;
use App\Article;
use DB;
use Excel;

class UploadController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$transactions = Transaction::all();

		return view('upload', compact('transactions'));
	}

	/**
	 * Load data from ajax (file and data range), parses csv table and adds new instances into db
	 * 50+ lines... fuck
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
	 */
	public function load(Request $request)
	{
		$time_start = microtime(true);
		$result = Excel::load($request['file'])->get()->toArray();
		$transaction = new Transaction();

		foreach ($result as $row) {
			if ( substr($row[0], -1) == '$' )  {
				$transaction->categoryName = trim(substr($row[0], 0, -1));
				$transaction->identifyDateRange($request, $row);
				$transaction->rowTransform($row);
				$transaction->dateMap = $row;

			} elseif ( substr($row[0], -1) == '@' ) {
				$transaction->groupName = trim(substr($row[0], 0, -1));

			} elseif ( substr($row[0], -1) == '#' ) {
				$transactionName = trim(substr($row[0], 0, -1));
				$dateRow = $transaction->getValidTrans($row);
				if ( empty($dateRow) ) continue;

				$transaction->category_id = $transaction->getInstanceId('category', $transaction->categoryName);
				$transaction->group_id =    $transaction->getInstanceId('group', $transaction->groupName);
				$transaction->article_id =  $transaction->getInstanceId('article', $transactionName);

				foreach ($dateRow as $date => $sum) {
					$date = $transaction->dateForm($date);
					// check if the transaction does not exist
					$transactionInstance = Transaction::where('group_id', $transaction->group_id)
					                                  ->where('category_id', $transaction->category_id)
					                                  ->where('article_id', $transaction->article_id)
					                                  ->where('date', $date)
					                                  ->first();
					if ( !is_null($transactionInstance) ) continue;

					$transaction->date = $date;
					$transaction->sum =  (int) str_replace(',', '', $sum);

					if ($transaction->insertRow($transaction->getAttributes())) {
						$transaction->transactionCount++;
					} else {
						return 'Something went wrong';
					}
				}
			}
		}

		Transaction::insert($transaction->insertData);

		return view('pieces.upload.ajax-response', [
			'groupCount' => $transaction->groupCount,
			'catCount' => $transaction->categoryCount,
			'transCount' => $transaction->transactionCount,
			'time' => (microtime(true) - $time_start)
		]);
	}

	/**
	 * Clears all data
	 */
	public function truncateDB()
	{
		Transaction::truncate();
		Category::truncate();
		Group::truncate();
		Article::truncate();

		return back();
	}
}
