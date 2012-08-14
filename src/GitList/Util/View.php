<?php

namespace GitList\Util;

class View
{
    /**
     * Builds a breadcrumb array based on a path spec
     *
     * @param  string $spec Path spec
     * @return array  Array with parts of the breadcrumb
     */
    public function getBreadcrumbs($spec)
    {
        if (!$spec) {
            return array();
        }

        $paths = explode('/', $spec);

        foreach ($paths as $i => $path) {
            $breadcrumbs[] = array(
                'dir'  => $path,
                'path' => implode('/', array_slice($paths, 0, $i + 1)),
            );
        }

        return $breadcrumbs;
    }

    public function getPager($pageNumber, $totalCommits)
    {
        $pageNumber = (empty($pageNumber)) ? 0 : $pageNumber;
        $lastPage = intval($totalCommits / 15);
        // If total commits are integral multiple of 15, the lastPage will be commits/15 - 1.
        $lastPage = ($lastPage * 15 == $totalCommits) ? $lastPage - 1 : $lastPage;
        $nextPage = $pageNumber + 1;
        $previousPage = $pageNumber - 1;

        return array('current' => $pageNumber,
                     'next' => $nextPage,
                     'previous' => $previousPage,
                     'last' => $lastPage,
                     'total' => $totalCommits,
        );
    }

		/**
		 * This function prints the difference between two php datetime objects
		 * in a more human readable form
		 * inputs should be like strtotime($date)
		 * Adapted from https://gist.github.com/207624 python version
		 * From https://gist.github.com/1053741
		 */
		public static function getDate($now, $otherDate=null, $offset=null){
			if($otherDate != null){
				$offset = $now - $otherDate;
			}

			if($offset != null){
				$deltaS = $offset%60;
				$offset /= 60;
				$deltaM = $offset%60;
				$offset /= 60;
				$deltaH = $offset%24;
				$offset /= 24;
				$deltaD = ($offset > 1)?ceil($offset):$offset;
			} else {
				throw new \Exception("Must supply otherdate or offset (from now)");
			}
			if($deltaD > 1){
				if($deltaD > 365){
					$years = ceil($deltaD/365);
					if($years ==1){
						return "last year"; 
					} else{
						return "<br>$years years ago";
					}	
				}
				/*
				if($deltaD > 6){
					return date('d-M',strtotime("$deltaD days ago"));
				}		
				 */
				return "$deltaD days ago";
			}
			if($deltaD == 1){
				return "Yesterday";
			}
			if($deltaH == 1){
				return "last hour";
			}
			if($deltaM == 1){
				return "last minute";
			}
			if($deltaH > 0){
				return $deltaH." hours ago";
			}
			if($deltaM > 0){
				return $deltaM." minutes ago";
			}
			else{
				return "few seconds ago";
			}
		}
}
