		$html .= '<li>';
		$html .= '<a href="'.${{entity}}->get{{Entity}}Url().'">'.${{entity}}->get{{EntityNameMagicCode}}().'</a>';
		if (count($activeChildren) > 0) {
			$html .= '<ul>';
			foreach ($children as $child){
				$html .= $this->draw{{Entity}}($child, $level+1);
			}
			$html .= '</ul>';
		}
		$html .= '</li>';
		return $html;
	}
}