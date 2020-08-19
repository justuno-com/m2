<?php
namespace Justuno\M2\Plugin\App\Router;
use Justuno\M2\Controller\Js;
use Magento\Framework\App\Router\ActionList as Sb;
# 2020-03-14
# "Respond to the `/justuno/service-worker.js` request with the provided JavaScript":
# https://github.com/justuno-com/m2/issues/10
final class ActionList {
	/**
	 * 2020-03-14
	 * @see \Magento\Framework\App\Router\ActionList::get()
	 * https://github.com/magento/magento2/blob/2.0.0/lib/internal/Magento/Framework/App/Router/ActionList.php#L63-L94
	 * https://github.com/magento/magento2/blob/2.3.4/lib/internal/Magento/Framework/App/Router/ActionList.php#L82-L114
	 * @param Sb $sb
	 * @param \Closure $f
     * @param string $m
     * @param string $area
     * @param string $ns
     * @param string $action
	 * @return string
	 */
	function aroundGet(Sb $sb, \Closure $f, $m, $area, $ns, $action) {return 
		$m === df_module_name($this) && df_ends_with($action, '.js') ? Js::class : $f($m, $area, $ns, $action)
	;}
}