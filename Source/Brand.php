<?php
namespace Justuno\M2\Source;
# 2019-11-15
final class Brand extends \Justuno\Core\Config\Source {
	/**
	 * 2019-11-15
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()
	 * @return array(string => string)
	 */	
	protected function map() {return df_map_0(array_column(
		array_filter(
			df_fetch('eav_attribute', ['attribute_code', 'frontend_label', 'is_user_defined'], 'entity_type_id', 4)
			,function(array $a) {return
				/**
				 * 2019-10-25 Dmitry Fedyuk https://www.upwork.com/fl/mage2pro
				 * "The `manufaturer` attribute is absent in the «Choose Brand Attribute» backend dropdown":
				 * https://github.com/justuno-com/m2/issues/3
				 */
				!$a['is_user_defined'] || 'manufacturer' === $a['attribute_code']
			;}
		)
		,'frontend_label', 'attribute_code'
	));}
}
