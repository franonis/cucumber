/*
* 依赖于jQuery和echars.min.js
*
*/

var DEFAULT_VALUE = '---';

/*
 *  渲染整个页面
 */
function renderPage(features, proteins){
	var count = 0;
	for (i in proteins){
		count ++;
	}


	// render pc_feature_checker
	renderFeatureChecker(features);

	if(count > 1){
		renderMulProteins(features, proteins);
	} else {
		renderOneProtein(features, proteins);
	}
}



/*
 *  渲染只有一个Protein的页面
 */
function renderFeatureChecker(features) {
	// body...
}

/*
 *  渲染多个proteins的页面
 */
function renderMulProteins(features, proteins) {
	$('#pca_title').text('Compare Proteins');
}

/*
 *  渲染只有一个Protein的页面
 */
function renderOneProtein(features, protein, col='col-md-12') {
	var name; // 蛋白质名称
	for(i in protein){
		name = i;
	}

	pdom_id = name.replace('.','_');
	$('#pca').append('<div class="'+col+'" id="'+ pdom_id +'"></div>');
	$('#'+ pdom_id).append('<h1 id="pca_title">Protein '+ name + '</h1>');

	renderPercentPerProtein(pdom_id, getFeatureValue('percent_per_protein', features, protein[name]) , features);
	renderSequenceLength(pdom_id, getFeatureValue('sequence_length', features, protein[name]));
	renderMolecularWeight(pdom_id, getFeatureValue('molecular_weight', features, protein[name]));
	renderGravy(pdom_id, getFeatureValue('gravy', features, protein[name]));
	renderCharge(pdom_id, getFeatureValue('charge', features, protein[name]));
	renderMolarExtinctionCoefficient(pdom_id, getFeatureValue('molar_extinction_coefficient', features, protein[name]));
	renderIsoElectricPoint(pdom_id, getFeatureValue('iso_electric_point', features, protein[name]));
	renderAliphaticIndex(pdom_id, getFeatureValue('aliphatic_index', features, protein[name]));
	renderSecondaryStructure(pdom_id, getFeatureValue('secondary_structure', features, protein[name]));
	renderCoil(pdom_id, getFeatureValue('coil', features, protein[name]));
	renderLowComplexity(pdom_id, getFeatureValue('low_complexity', features, protein[name]));
	renderPEST(pdom_id, getFeatureValue('PEST', features, protein[name]));
	renderTransmember(pdom_id, getFeatureValue('transmember', features, protein[name]));
	renderDisorder(pdom_id, getFeatureValue('disorder', features, protein[name]));
	renderProsite(pdom_id, getFeatureValue('prosite', features, protein[name]));
	
}

function renderProsite(pdom_id, prosite) {
	if(prosite === null) {prosite = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_prosite+' + '" class="text-center"><h4>Prosite</h4><p class="feature-value">'+ prosite  +' </p></div>');
}

function renderDisorder(pdom_id, disorder) {
	if(disorder === null) {disorder = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_disorder+' + '" class="text-center"><h4>Disorder</h4><p class="feature-value">'+ disorder  +' </p></div>');
}

function renderTransmember(pdom_id, transmember) {
	if(transmember === null) {transmember = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_transmember+' + '" class="text-center"><h4>Transmember</h4><p class="feature-value">'+ transmember  +' </p></div>');
}

function renderPEST(pdom_id, pest) {
	if(pest === null) {pest = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_pest+' + '" class="text-center"><h4>PEST</h4><p class="feature-value">'+ pest  +' </p></div>');
}

function renderLowComplexity(pdom_id, lc) {
	if(lc === null) {lc = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_low_complexity+' + '" class="text-center"><h4>Low Complexity</h4><p class="feature-value">'+ lc  +' </p></div>');
}

function renderCoil(pdom_id, coil) {
	if(coil === null) {coil = DEFAULT_VALUE;}
	// C/E/H - start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_secondary_structure+' + '" class="text-center"><h4>Coil</h4><p class="feature-value">'+ coil +' </p></div>');
}

function renderSecondaryStructure(pdom_id, ss) {
	if(ss === null) {ss = DEFAULT_VALUE;}
	// C/E/H - start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_secondary_structure+' + '" class="text-center"><h4>Secondary Structure</h4><p class="feature-value">'+ ss +' </p></div>');
}

function renderAliphaticIndex(pdom_id, ai) {
	if(ai === null) {ai = DEFAULT_VALUE;}
	ai = ai.substr(0, ai.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_aliphatic_index+' + '" class="text-center"><h4>Aliphatic Index</h4><p class="feature-value">'+ ai +' </p></div>');
}

function renderIsoElectricPoint(pdom_id, iep) {
	if(iep === null) {iep = DEFAULT_VALUE;}
	iep = iep.substr(0, iep.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_iso_electric_point+' + '" class="text-center"><h4>Iso Electric Point</h4><p class="feature-value">'+ iep +' </p></div>');
}

function renderMolarExtinctionCoefficient(pdom_id, mec) {
	if(mec === null) {mec = DEFAULT_VALUE;}
	mec = mec.substr(0, mec.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_molar_extinction_coefficient+' + '" class="text-center"><h4>Molar Extinction Coefficient</h4><p class="feature-value">'+ mec +' </p></div>');
}

function renderCharge(pdom_id, charge) {
	if(charge === null) {charge = DEFAULT_VALUE;}
	charge = charge.substr(0, charge.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_charge+' + '" class="text-center"><h4>Charge</h4><p class="feature-value">'+ charge +' </p></div>');
}

function renderGravy(pdom_id, gravy) {
	if(gravy === null) {gravy = DEFAULT_VALUE;}
	gravy = gravy.substr(0, gravy.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_gravy+' + '" class="text-center"><h4>Gravy</h4><p class="feature-value">'+ gravy +' </p></div>');
}

function renderMolecularWeight(pdom_id, weight) {
	if(weight === null) {weight = DEFAULT_VALUE;}
	$('#'+pdom_id).append('<div id="' + pdom_id + '_molecular_weight'+'" class="text-center"><h4>Molecular Weight</h4><p class="feature-value">'+ weight+' </p></div>');
}

function renderSequenceLength(pdom_id, length) {
	if(length === null) {length = DEFAULT_VALUE;}
	$('#'+pdom_id).append('<div id="' + pdom_id + '_sequence_length'+'" class="text-center"><h4>Protein Length</h4><p class="feature-value">'+length+' bp</p></div>');
}



function renderPercentPerProtein(pdom_id, value, features) {
	var feature_name = 'percent_per_protein';
	var amino_acids  = getFeatureInfo(feature_name, features); amino_acids = amino_acids['comment'].split('-');

	if(value === null){
		$('#'+pdom_id).append('<div id="' + pdom_id + '_percent_per_protein" class="text-center"><h4>Amino acid Percentage In the Protein</h4><p class="feature-value">'+DEFAULT_VALUE+'</p></div>');
		return;
	}

	value = value.split('-');
	feature_name = feature_name.replace(/\_/, ' ').toUpperCase();

	$('#'+ pdom_id).append('<div id="' + feature_name + '_' + pdom_id + '" style="width: 100%;height:400px;"></div>');
	
	data = [];
	for(i in amino_acids){
		data.push({value: value[i], name: amino_acids[i]})
	}

	var percent_per_protein_chart = echarts.init(document.getElementById(feature_name + '_' + pdom_id));
	var option = {
	    title : {
	        text: 'Amino acid Percentage In the Protein',
	        x: 'center'
	    },
	    tooltip : {
	        trigger: 'Amino acid',
	        formatter: "{a} <br/>{b} : {c} ({d}%)"
	    },
	    
	    series : [
	        {
	            name: 'Amino acid Percentage In the Protein',
	            type: 'pie',
	            radius : '55%',
	            center: ['50%', '60%'],
	            data: data,
	            itemStyle: {
	                emphasis: {
	                    shadowBlur: 10,
	                    shadowOffsetX: 0,
	                    shadowColor: 'rgba(0, 0, 0, 0.5)'
	                }
	            }
	        }
	    ]
	};

	percent_per_protein_chart.setOption(option);
}


// 获取某个特征的值，name=特征名称  features=特征列表 protein=单个蛋白的数据
function getFeatureValue(name, features, values) {
	feature_idx = getFeatureIndex(name, features);
	return feature_idx === null ? null : (values[feature_idx] ? values[feature_idx] : null);
}

function getFeatureInfo(name, features) {
	for(i in features){
		if(features[i].name == name){
			return features[i];
		}
	}
	return null;
}


function getFeatureIndex(name, features) {
	var feature_idx = null;
	for(i in features){
		if(features[i].name == name){ feature_idx = i; break;}
	}
	return feature_idx;
}