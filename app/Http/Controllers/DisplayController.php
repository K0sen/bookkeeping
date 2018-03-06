<?php

namespace App\Http\Controllers;

use App\Category;
use App\Group;
use App\Article;
use App\Transaction;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
	/**
	 * Display a tree of the articles.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$transactions = Transaction::all();
		$selectTable = [];

		// get table where stored array: [category_name] => [group_name] => array of articles
		// i used article name as key value to prevent name duplication
		foreach ($transactions as $transaction) {
			$category = $transaction->category;
			$group = $transaction->group;
			$article = $transaction->article;
			$selectTable[$category->name][$group->name][$article->name] =
				"[{$category->id}][{$group->id}][{$article->id}]";
		}

		return view('display', compact('selectTable'));
	}

	/**
	 * Formats the request and returns the table of sorted by date transactions with sums
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getTable(Request $request)
	{
		$table = [];
		// get array of articles
		parse_str($request['articles'], $articlesArray);

		if ($articlesArray) {
			foreach ( $articlesArray['articles'] as $categoryId => $groups ) {
				$categoryName = Category::find( $categoryId )->name;
				$categorySum  = 0;

				foreach ( $groups as $groupId => $articles ) {
					$groupName = Group::find( $groupId )->name;
					$groupSum  = 0;

					foreach ( $articles as $articleId => $on ) {
						$articleName  = Article::find( $articleId )->name;
						$articleSum   = 0;
						$transactions = Transaction::whereBetween( 'date', [
							$request['date-from'],
							$request['date-to']
						] )
						                           ->where( 'category_id', $categoryId )
						                           ->where( 'group_id', $groupId )
						                           ->where( 'article_id', $articleId )
						                           ->pluck( 'sum', 'date' )
						                           ->all();
						foreach ( $transactions as $sum ) {
							$categorySum += $sum;
							$groupSum    += $sum;
							$articleSum  += $sum;
						}

						$table[ $categoryName ]['$sum']                               = $categorySum;
						$table[ $categoryName ][ $groupName ]['$sum']                 = $groupSum;
						$table[ $categoryName ][ $groupName ][ $articleName ]['$sum'] = $articleSum;
						$table[ $categoryName ][ $groupName ][ $articleName ][]       = $transactions;
					}
				}
			}
		}

		$period = new \DatePeriod(
			new \DateTime($request['date-from']),
			new \DateInterval('P1D'),
			new \DateTime($request['date-to'])
		);

		return view('pieces.display.ajax-table', compact('table', 'period'));
	}
}
