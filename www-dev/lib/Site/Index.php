<?php
/**
 * @package Open Tucson - Frontend
 * @author aslattery
 * @copyright MIT License
 */

namespace OpenTucson\Site;

class Index {
  /**
   * GET action.
   *
   * @param  $request
   * @return null
   */
  public function GET($request){
    \OpenTucson\Frontend::render(__DIR__.'/templates/homepage.html');
  }
  /**
   * POST action.
   *
   * @param  $request
   * @return null
   */
  public function POST($request){
    $this->get($request);
  }
}
