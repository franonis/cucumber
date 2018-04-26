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

	if(count == 1){
		$('#pca_title').text('Protein');
		var name; // 蛋白质名称
		for(i in proteins){
			name = i;
		}
		renderOneProtein(features, name, proteins[name]);
	} else {
		$('#pca_title').text('Compare Proteins');
		renderMulProteins(features, proteins, count);
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
function renderMulProteins(features, proteins, count) {
	$('#pca_title').text('Compare Proteins');

	var col = count == 2 ? 'col-md-6' : 'col-md-4';

	var new_row_flag = 0;
	for(name in proteins){
		new_row_flag ++;
		new_row = (new_row_flag % 3 == 0) ? true : false;
		renderOneProtein(features, name, proteins[name], col, new_row);
	}
}

/*
 *  渲染只有一个Protein的页面
 */
function renderOneProtein(features, name, protein, col='col-md-12', new_row=false) {
	pdom_id = name.replace('.','_');
	$('#pca').append('<div class="'+col+'" id="'+ pdom_id +'"></div>');
	$('#'+ pdom_id).append('<h3 class="protein_title">'+ name + '</h3>');

	renderPercentPerProtein(pdom_id, getFeatureValue('percent_per_protein', features, protein) , features);
	renderSequenceLength(pdom_id, getFeatureValue('sequence_length', features, protein));
	renderMolecularWeight(pdom_id, getFeatureValue('molecular_weight', features, protein));
	renderGravy(pdom_id, getFeatureValue('gravy', features, protein));
	renderCharge(pdom_id, getFeatureValue('charge', features, protein));
	renderMolarExtinctionCoefficient(pdom_id, getFeatureValue('molar_extinction_coefficient', features, protein));
	renderIsoElectricPoint(pdom_id, getFeatureValue('iso_electric_point', features, protein));
	renderAliphaticIndex(pdom_id, getFeatureValue('aliphatic_index', features, protein));
	renderSecondaryStructure(pdom_id, getFeatureValue('secondary_structure', features, protein));
	renderCoil(pdom_id, getFeatureValue('coil', features, protein));
	renderLowComplexity(pdom_id, getFeatureValue('low_complexity', features, protein));
	renderPEST(pdom_id, getFeatureValue('PEST', features, protein));
	renderTransmember(pdom_id, getFeatureValue('transmember', features, protein));
	renderDisorder(pdom_id, getFeatureValue('disorder', features, protein));
	renderProsite(pdom_id, getFeatureValue('prosite', features, protein));
	renderPfam(pdom_id, getFeatureValue('pfam', features, protein));
	renderProteinFunction(pdom_id, getFeatureValue('protein_function', features, protein));
	renderKEGG(pdom_id, getFeatureValue('kegg', features, protein));
	renderSignalp(pdom_id, getFeatureValue('signalp', features, protein));
	renderLocation(pdom_id, getFeatureValue('location', features, protein));
	renderNetphos(pdom_id, getFeatureValue('netphos', features, protein));
	renderOGlycosylation(pdom_id, getFeatureValue('O_Glycosylation', features, protein));
	renderNGlycosylation(pdom_id, getFeatureValue('N_Glycosylation', features, protein));
	if(new_row) {
		$('#'+ pdom_id).append('<div class="row"><hr></div>');
	}
}

function renderSequenceLength(pdom_id, length) {
	if(length === null) {length = DEFAULT_VALUE;}
	$('#'+pdom_id).append(
		'<div id="' + pdom_id + '_sequence_length'+'" class="text-center sequence-length">'+
		'<h4>Protein Length</h4><p class="feature-value">'+length+
		' bp <a class="button button-tiny" href="/protein/'+ pdom_id.replace('_', '.') +'/sequence/download"><i class="fa fa-download"></i> FASTA</a></p>' +
		'</div>'
	);
}


function renderNGlycosylation(pdom_id, ng) {
	if(ng === null) {ng = DEFAULT_VALUE;}
	// "site-type"
	$('#'+pdom_id).append('<div id="' + pdom_id + '_N_Glycosylation+' + '" class="text-center N_Glycosylation"><h4>N Glycosylation</h4><p class="feature-value">'+ ng  +' bp</p></div>');
}

function renderOGlycosylation(pdom_id, og) {
	if(og === null) {og = DEFAULT_VALUE;}
	// "site-type"
	$('#'+pdom_id).append('<div id="' + pdom_id + '_O_Glycosylation+' + '" class="text-center O_Glycosylation"><h4>O Glycosylation</h4><p class="feature-value">'+ og  +' bp</p></div>');
}

function renderNetphos(pdom_id, netphos) {
	if(netphos === null) {netphos = DEFAULT_VALUE;}
	// "site-type"
	$('#'+pdom_id).append('<div id="' + pdom_id + '_netphos+' + '" class="text-center netphos"><h4>Netphos</h4><p class="feature-value">'+ netphos  +' </p></div>');
}

function renderLocation(pdom_id, location) {
	if(location === null) {location = DEFAULT_VALUE;}
	// "Cytoplasm-Nucleus-Peroxisome-Mitochondrion-Chloroplast-Golgi_apparatus-Vacuole-Plasma_membrane-ER-Extracellular_space"
	$('#'+pdom_id).append('<div id="' + pdom_id + '_location+' + '" class="text-center location"><h4>location</h4><p class="feature-value">'+ location  +' </p></div>');
}

function renderSignalp(pdom_id, signalp) {
	if(signalp === null) {signalp = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_signalp+' + '" class="text-center signalp"><h4>Signalp</h4><p class="feature-value">'+ signalp  +' </p></div>');
}

function renderKEGG(pdom_id, kegg) {
	if(kegg === null) {kegg = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_kegg+' + '" class="text-center kegg"><h4>KEGG</h4><p class="feature-value">'+ kegg  +' </p></div>');
}

function renderProteinFunction(pdom_id, pf) {
	if(pf === null) {pf = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_protein_function+' + '" class="text-center protein_function"><h4>Protein Function</h4><p class="feature-value">'+ pf  +' </p></div>');
}

function renderPfam(pdom_id, pfam) {
	if(pfam === null) {pfam = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_pfam+' + '" class="text-center pfam"><h4>Pfam</h4><p class="feature-value">'+ pfam  +' </p></div>');
}

function renderProsite(pdom_id, prosite) {
	if(prosite === null) {prosite = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_prosite+' + '" class="text-center prosite"><h4>Prosite</h4><p class="feature-value">'+ prosite  +' </p></div>');
}

function renderDisorder(pdom_id, disorder) {
	if(disorder === null) {disorder = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_disorder+' + '" class="text-center disorder"><h4>Disorder</h4><p class="feature-value">'+ disorder  +' </p></div>');
}

function renderTransmember(pdom_id, transmember) {
	if(transmember === null) {transmember = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_transmember+' + '" class="text-center transmember"><h4>Transmember</h4><p class="feature-value">'+ transmember  +' </p></div>');
}

function renderPEST(pdom_id, pest) {
	if(pest === null) {pest = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_pest+' + '" class="text-center pest"><h4>PEST</h4><p class="feature-value">'+ pest  +' </p></div>');
}

function renderLowComplexity(pdom_id, lc) {
	if(lc === null) {lc = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_low_complexity+' + '" class="text-center lc"><h4>Low Complexity</h4><p class="feature-value">'+ lc  +' </p></div>');
}

function renderCoil(pdom_id, coil) {
	if(coil === null) {coil = DEFAULT_VALUE;}
	// C/E/H - start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_secondary_structure+' + '" class="text-center coil"><h4>Coil</h4><p class="feature-value">'+ coil +' </p></div>');
}

function renderSecondaryStructure(pdom_id, ss) {
	if(ss === null) {ss = DEFAULT_VALUE;}
	// C/E/H - start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_secondary_structure+' + '" class="text-center secondary-structure"><h4>Secondary Structure</h4><p class="feature-value">'+ ss +' </p></div>');
}

function renderAliphaticIndex(pdom_id, ai) {
	if(ai === null) {ai = DEFAULT_VALUE;}
	ai = ai.substr(0, ai.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_aliphatic_index+' + '" class="text-center ai"><h4>Aliphatic Index</h4><p class="feature-value">'+ ai +' </p></div>');
}

function renderIsoElectricPoint(pdom_id, iep) {
	if(iep === null) {iep = DEFAULT_VALUE;}
	iep = iep.substr(0, iep.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_iso_electric_point+' + '" class="text-center iep"><h4>Iso Electric Point</h4><p class="feature-value">'+ iep +' </p></div>');
}

function renderMolarExtinctionCoefficient(pdom_id, mec) {
	if(mec === null) {mec = DEFAULT_VALUE;}
	mec = mec.substr(0, mec.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_molar_extinction_coefficient+' + '" class="text-center mec"><h4>Molar Extinction Coefficient</h4><p class="feature-value">'+ mec +' </p></div>');
}

function renderCharge(pdom_id, charge) {
	if(charge === null) {charge = DEFAULT_VALUE;}
	charge = charge.substr(0, charge.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_charge+' + '" class="text-center charge"><h4>Charge</h4><p class="feature-value">'+ charge +' </p></div>');
}

function renderGravy(pdom_id, gravy) {
	if(gravy === null) {gravy = DEFAULT_VALUE;}
	gravy = gravy.substr(0, gravy.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_gravy+' + '" class="text-center gravy"><h4>Gravy</h4><p class="feature-value">'+ gravy +' </p></div>');
}

function renderMolecularWeight(pdom_id, weight) {
	if(weight === null) {weight = DEFAULT_VALUE;}
	$('#'+pdom_id).append('<div id="' + pdom_id + '_molecular_weight'+'" class="text-center molecular-weight"><h4>Molecular Weight</h4><p class="feature-value">'+ weight+' </p></div>');
}





function renderPercentPerProtein(pdom_id, value, features) {
	var feature_name = 'percent_per_protein';
	var amino_acids  = getFeatureInfo(feature_name, features); amino_acids = amino_acids['comment'].split('-');

	if(value === null){
		$('#'+pdom_id).append('<div id="' + pdom_id + '_percent_per_protein" class="text-center percent_per_protein"><h4>Amino acid Percentage In the Protein</h4><p class="feature-value">'+DEFAULT_VALUE+'</p></div>');
		return;
	}

	value = value.split('-');
	feature_name = feature_name.replace(/\_/, ' ').toUpperCase();

	$('#'+ pdom_id).append('<div id="' + feature_name + '_' + pdom_id + '" class="percent_per_protein"></div>');
	
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
	            name: 'Amino acid Percentage',
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