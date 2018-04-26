/*
* 依赖于jQuery, echars.min.js, bootstrap
*
*/

var DEFAULT_VALUE = '---';
var C_LABLE_CLASS = '';
var H_LABLE_CLASS = 'label-warning';
var E_LABEL_CLASS = 'label-primary';
var COIL_LABEL_CLASS = 'label-info';
var LOW_COMPLEXITY_LABEL_CLASS = 'label-primary';
var PEST_LABEL_CLASS = 'label-danger';
var INTRACELLULAR_LABEL_CLASS = 'label-warning';
var EXTRACELLULAR_LABEL_CLASS = 'label-info';
var TRANSMEMBRANE_HELIX_LABEL_CLASS = 'label-danger';
var DISORDER_LABEL_CLASS= 'label-danger';
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
	renderSequenceLength(pdom_id, getFeatureValue('sequence_length', features, protein), name);
	renderMolecularWeight(pdom_id, getFeatureValue('molecular_weight', features, protein));
	renderGravy(pdom_id, getFeatureValue('gravy', features, protein));
	renderCharge(pdom_id, getFeatureValue('charge', features, protein));
	renderMolarExtinctionCoefficient(pdom_id, getFeatureValue('molar_extinction_coefficient', features, protein));
	renderIsoElectricPoint(pdom_id, getFeatureValue('iso_electric_point', features, protein));
	renderAliphaticIndex(pdom_id, getFeatureValue('aliphatic_index', features, protein));
	renderSecondaryStructure(pdom_id, getFeatureValue('secondary_structure', features, protein), protein.sequence);
	renderCoil(pdom_id, getFeatureValue('coil', features, protein), protein.sequence);
	renderLowComplexity(pdom_id, getFeatureValue('low_complexity', features, protein), protein.sequence);
	renderPEST(pdom_id, getFeatureValue('PEST', features, protein), protein.sequence);
	renderTransmembrane(pdom_id, getFeatureValue('transmember', features, protein), protein.sequence);
	renderDisorder(pdom_id, getFeatureValue('disorder', features, protein), protein.sequence);
	renderProsite(pdom_id, getFeatureValue('prosite', features, protein));
	renderPfam(pdom_id, getFeatureValue('pfam', features, protein));
	renderProteinFunction(pdom_id, getFeatureValue('protein_function', features, protein));
	renderKEGG(pdom_id, getFeatureValue('kegg', features, protein));
	renderSignalp(pdom_id, getFeatureValue('signalp', features, protein));
	renderLocation(pdom_id, getFeatureValue('location', features, protein));
	renderNetphos(pdom_id, getFeatureValue('netphos', features, protein));
	renderOGlycosylation(pdom_id, getFeatureValue('O_Glycosylation', features, protein));
	renderNGlycosylation(pdom_id, getFeatureValue('N_Glycosylation', features, protein));
}

/*
 *	渲染单个特征
 */

function renderPercentPerProtein(pdom_id, value, features) {
	var feature_name = 'percent_per_protein';
	var amino_acids  = getFeatureInfo(feature_name, features); amino_acids = amino_acids['comment'].split('-');

	if(value === null){
		$('#'+pdom_id).append('<div id="' + pdom_id + '_percent_per_protein" class="text-center percent_per_protein"><h4>Amino acid Percentage</h4><p class="feature-value">'+DEFAULT_VALUE+'</p></div>');
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
	        text: 'Amino acid Percentage',
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

function renderSequenceLength(pdom_id, length, name) {
	if(length === null) {
		length = DEFAULT_VALUE;
		$('#'+pdom_id).append('<div id="' + pdom_id + '_sequence_length" class="text-center sequence-length"><h4>Protein Length</h4><div class="feature-value">'+ length+' </div></div>');
	}
	$('#'+pdom_id).append(
		'<div id="' + pdom_id + '_sequence_length" class="text-center sequence-length">'+
		'<h4>Protein Length</h4><div class="feature-value">'+length+
		' bp <a class="button button-tiny" href="/protein/'+ name +'/sequence/download"><i class="fa fa-download"></i> FASTA</a></div>' +
		'</div>'
	);
}

function renderMolecularWeight(pdom_id, weight) {
	if(weight === null) {weight = DEFAULT_VALUE;}
	$('#'+pdom_id).append('<div id="' + pdom_id + '_molecular_weight" class="text-center molecular-weight"><h4>Molecular Weight</h4><div class="feature-value">'+ weight+' </div></div>');
}

function renderGravy(pdom_id, gravy) {
	if(gravy === null) {gravy = DEFAULT_VALUE;}
	gravy = gravy.substr(0, gravy.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_gravy" class="text-center gravy"><h4>Gravy</h4><div class="feature-value">'+ gravy +' </div></div>');
}

function renderCharge(pdom_id, charge) {
	if(charge === null) {charge = DEFAULT_VALUE;}
	charge = charge.substr(0, charge.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_charge+" class="text-center charge"><h4>Charge</h4><div class="feature-value">'+ charge +' </div></div>');
}


function renderMolarExtinctionCoefficient(pdom_id, mec) {
	if(mec === null) {mec = DEFAULT_VALUE;}
	mec = mec.substr(0, mec.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_molar_extinction_coefficient" class="text-center mec"><h4>Molar Extinction Coefficient</h4><div class="feature-value">'+ mec +' </div></div>');
}

function renderIsoElectricPoint(pdom_id, iep) {
	if(iep === null) {iep = DEFAULT_VALUE;}
	iep = iep.substr(0, iep.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_iso_electric_point" class="text-center iep"><h4>Iso Electric Point</h4><div class="feature-value">'+ iep +' </div></div>');
}

function renderAliphaticIndex(pdom_id, ai) {
	if(ai === null) {ai = DEFAULT_VALUE;}
	ai = ai.substr(0, ai.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_aliphatic_index" class="text-center ai"><h4>Aliphatic Index</h4><div class="feature-value">'+ ai +' </div></div>');
}


function renderSecondaryStructure(pdom_id, ss, seq) {
	if(ss === null) {
		ss = DEFAULT_VALUE;
	} else {
		var html = '';
		html += '<p class="text-left">';
		ss = ss.split(';');
		for(i in ss){
			var loc = ss[i].split('-');
			var type, start, len;
			if(loc[0] == 'C'){type = C_LABLE_CLASS;} 
			else if(loc[0] == 'H'){type = H_LABLE_CLASS;}
			else {type = E_LABEL_CLASS;}
			start = parseInt(loc[1]) - 1;
			end = parseInt(loc[2]) - start;
			var subseq = seq.substr(start, end);
			for(j in subseq){
				html += '<label class="'+ type +'">' + subseq[j] + '</label>';
			}
		}
		html += '</p>';
		ss = html;
	}
	var legend = '<p>Legend: <label class="'+H_LABLE_CLASS+'">Helix</label> <label class="' + E_LABEL_CLASS + '">Sheet</label></p>';
	$('#'+pdom_id).append('<div id="' + pdom_id + '_secondary_structure" class="text-center secondary-structure"><h4>Secondary Structure</h4>'+legend+'<div class="feature-value">'+ ss +' </div></div>');
}

function renderCoil(pdom_id, coil, seq) {
	if(coil === null) {
		coil = DEFAULT_VALUE;
	} else {
		var html = '<p class="text-left">';
		coils = coil.split(';');
		var locus = [];
		for(var i in coils){
			locus = locus.concat(parseInterval(coils[i]));
		}

		for(var i in seq){
			if(arrayContains(locus, parseInt(i)+1)){
				html += '<label class="'+ COIL_LABEL_CLASS +'">' + seq[i] + '</label>';
			} else {
				html += '<label>' + seq[i] + '</label>';
			}
		}

		coil = html + '</p>';
	}
	// C/E/H - start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_coil" class="text-center coil"><h4>Coil</h4><div class="feature-value">'+ coil +' </div></div>');
}

function renderLowComplexity(pdom_id, lc, seq) {
	if(lc === null) {lc = DEFAULT_VALUE;}
	else {
		var html = '<p class="text-left">';
		lc = lc.split(';');
		var locus = [];
		for(var i in lc){
			locus = locus.concat(parseInterval(lc[i]));
		}

		for(var i in seq){
			if(arrayContains(locus, parseInt(i)+1)){
				html += '<label class="'+ LOW_COMPLEXITY_LABEL_CLASS +'">' + seq[i] + '</label>';
			} else {
				html += '<label>' + seq[i] + '</label>';
			}
		}

		lc = html + '</p>';
	}

	$('#'+pdom_id).append('<div id="' + pdom_id + '_low_complexity+' + '" class="text-center lc"><h4>Low Complexity</h4><div class="feature-value">'+ lc  +'</div></div>');
}

function renderPEST(pdom_id, pest, seq) {
	if(pest === null) {pest = DEFAULT_VALUE;}
	else {
		var html = '<p class="text-left">';
		pest = pest.split(';');
		var locus = [];
		for(var i in pest){
			locus = locus.concat(parseInterval(pest[i]));
		}

		for(var i in seq){
			if(arrayContains(locus, parseInt(i)+1)){
				html += '<label class="'+ PEST_LABEL_CLASS +'">' + seq[i] + '</label>';
			} else {
				html += '<label>' + seq[i] + '</label>';
			}
		}

		pest = html + '</p>';
	}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_pest+' + '" class="text-center pest"><h4>PEST</h4><div class="feature-value">'+ pest  +' </div></div>');
}


function renderTransmembrane(pdom_id, transmembrane, seq) {
	if(transmembrane === null) {transmembrane = DEFAULT_VALUE;}
	else {
		var html = '';
		html += '<p class="text-left">';
		ts = transmembrane.split(';');
		for(i in ts){
			var loc = ts[i].split('-');
			var type, start, len;
			if(loc[0].match(/intra/i)){type = INTRACELLULAR_LABEL_CLASS;} 
			else if(loc[0].match(/trans/i)){type = TRANSMEMBRANE_HELIX_LABEL_CLASS;}
			else {type = EXTRACELLULAR_LABEL_CLASS;}
			start = parseInt(loc[1]) - 1;
			end = parseInt(loc[2]) - start;
			var subseq = seq.substr(start, end);
			for(j in subseq){
				html += '<label class="'+ type +'">' + subseq[j] + '</label>';
			}
		}
		html += '</p>';
		transmembrane = html;
	}

	var legend = '<p>Legend: <label class="'+ INTRACELLULAR_LABEL_CLASS +
				'">Intracellular</label> <label class="' + TRANSMEMBRANE_HELIX_LABEL_CLASS + 
				'">Transmembrane Helix</label> <label class="' + EXTRACELLULAR_LABEL_CLASS + 
				'">Extracellular</label></p>';
	$('#'+pdom_id).append('<div id="' + pdom_id + '_transmembrane+' + '" class="text-center transmembrane"><h4>Transmembrane</h4>' + legend + '<div class="feature-value">'+ transmembrane  +' </div></div>');
}

function renderDisorder(pdom_id, disorder, seq) {
	if(disorder === null) {disorder = DEFAULT_VALUE;}
	else {
		var html = '<p class="text-left">';
		disorder = disorder.split(';');
		var locus = [];
		for(var i in disorder){
			locus = locus.concat(parseInterval(disorder[i]));
		}

		for(var i in seq){
			if(arrayContains(locus, parseInt(i)+1)){
				html += '<label class="'+ DISORDER_LABEL_CLASS +'">' + seq[i] + '</label>';
			} else {
				html += '<label>' + seq[i] + '</label>';
			}
		}

		disorder = html + '</p>';
	}

	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_disorder+' + '" class="text-center disorder"><h4>Disorder</h4><div class="feature-value">'+ disorder  +' </div></div>');
}


function renderProsite(pdom_id, prosite) {
	var rows = '';
	if(prosite === null) {rows = '<tr><td colspan=4>No data available!</td></tr>';}
	else {
		prosite = prosite.split(';');
		for(var i in prosite){
			p = prosite[i].split('-');
			rows += '<tr><td>'+p[0]+'</td><td>'+p[1]+'</td><td>'+p[2]+'</td><td>'+p[3]+'</td></tr>';
		}
	}

	// prosite id, motif, start, end
	var table_head = '<table class="table table-hover"><thead><tr><th>Prosite ID</th><th>Motif</th><th>Start</th><th>End</th></thead>'
	var table_body = '<tbody>' + rows + '</tbody>';
	$('#'+pdom_id).append('<div id="' + pdom_id + '_prosite+' + '" class="text-center prosite"><h4>Prosite</h4><div class="feature-value">'+table_head + table_body +' </table></div></div>');
}

function renderPfam(pdom_id, pfam) {
	var rows = '';
	if(pfam === null) {rows = '<tr><td colspan=4>No data available!</td></tr>';}

	else {
		prosite = prosite.split(';');
		for(var i in prosite){
			p = prosite[i].split('-');
			rows += '<tr><td>'+p[0]+'</td><td>'+p[1]+'</td><td>'+p[2]+'</td><td>'+p[3]+'</td></tr>';
		}
	}

	// start   end     no_pfam domain_name     p-value
	var table_head = '<table class="table table-hover"><thead><tr><th>Pfam ID</th><th>Domain</th><th>Start</th><th>End</th><th>p-value</th></thead>'
	var table_body = '<tbody>' + rows + '</tbody>';
	$('#'+pdom_id).append('<div id="' + pdom_id + '_pfam+' + '" class="text-center prosite"><h4>Prosite</h4><div class="feature-value">'+table_head + table_body +' </table></div></div>');
}


function renderNGlycosylation(pdom_id, ng) {
	if(ng === null) {ng = DEFAULT_VALUE;}

	// "site-type"
	$('#'+pdom_id).append('<div id="' + pdom_id + '_N_Glycosylation+' + '" class="text-center N_Glycosylation"><h4>N Glycosylation</h4><div class="feature-value">'+ ng  +' bp</div></div>');
}

function renderOGlycosylation(pdom_id, og) {
	if(og === null) {og = DEFAULT_VALUE;}
	// "site-type"
	$('#'+pdom_id).append('<div id="' + pdom_id + '_O_Glycosylation+' + '" class="text-center O_Glycosylation"><h4>O Glycosylation</h4><div class="feature-value">'+ og  +' bp</div></div>');
}

function renderNetphos(pdom_id, netphos) {
	if(netphos === null) {netphos = DEFAULT_VALUE;}
	// "site-type"
	$('#'+pdom_id).append('<div id="' + pdom_id + '_netphos+' + '" class="text-center netphos"><h4>Netphos</h4><div class="feature-value">'+ netphos  +' </div></div>');
}

function renderLocation(pdom_id, location) {
	if(location === null) {location = DEFAULT_VALUE;}
	// "Cytoplasm-Nucleus-Peroxisome-Mitochondrion-Chloroplast-Golgi_apparatus-Vacuole-Plasma_membrane-ER-Extracellular_space"
	$('#'+pdom_id).append('<div id="' + pdom_id + '_location+' + '" class="text-center location"><h4>location</h4><div class="feature-value">'+ location  +' </div></div>');
}

function renderSignalp(pdom_id, signalp) {
	if(signalp === null) {signalp = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_signalp+' + '" class="text-center signalp"><h4>Signalp</h4><div class="feature-value">'+ signalp  +' </div></div>');
}

function renderKEGG(pdom_id, kegg) {
	if(kegg === null) {kegg = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_kegg+' + '" class="text-center kegg"><h4>KEGG</h4><div class="feature-value">'+ kegg  +' </div></div>');
}

function renderProteinFunction(pdom_id, pf) {
	if(pf === null) {pf = DEFAULT_VALUE;}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_protein_function+' + '" class="text-center protein_function"><h4>Protein Function</h4><div class="feature-value">'+ pf  +' </div></div>');
}



















/**
 * 数组是否包含某个值
 * @param  string interval 区间字符串，如‘73-89’
 * @return array          
 */
function arrayContains(arr, obj) {
	var i = arr.length;
	while (i--) {
		if (arr[i] == parseInt(obj)) {
			return true;
		}
	}
	return false;
}



/**
 * 解析区间为数组
 * @param  string interval 区间字符串，如‘73-89’
 * @return array          
 */
function parseInterval(interval) {
	if(interval.indexOf('-') == -1){
		return [];
	}
	interval = interval.split('-');
	min = parseInt(interval[0]);
	max = parseInt(interval[1]);
	var arr = [];
	for(var i = min; i <= max; i++){
		arr.push(i);
	}
	return arr;
}


/**
 * 计算一个数值是否属于某个区间
 * 
 * @param  {[int]} needle   判断的数值
 * @param  {[string]} interval 区间:min-max 如2-3
 * @return {[boolean]}          
 */
function between(needle, interval) {
	if(interval.indexOf('-') == -1){
		return false;
	}
	needle = parseInt(needle);
	interval = interval.split('-');
	min = parseInt(interval[0]);
	max = parseInt(interval[1]);

	return needle >= min && needle <= max;
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