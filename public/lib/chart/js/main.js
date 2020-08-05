
function getData() {

    return {
        "name": "Acupping",
        "children": [{
            "name": "Doctors",
            "size": 80,
            "children": [{
                "name": "Male",
                "size": 55
            }, {
                "name": "Female",
                "size": 45
            }]
        }, {
            "name": "Mining Engg",
            "size": 20,
            "children": [{
                "name": "Male",
                "size": 80
            }, {
                "name": "Female",
                "size": 20
            }]
        }]
    }
};

var colorScheme = ["#FFFFFF","#FFFFFF","#7986CB","#A1887F","#90A4AE","#AED581","#9575CD","#FF8A65","#4DB6AC","#FFF176","#64B5F6","#00E676"];
dataset = getData();

var width = 500,
height = 500,
radius = Math.min(width / 2, height / 2) * 0.90;

var x = d3.scale.linear()
.range([0, 2 * Math.PI]);

var y = d3.scale.linear()
.range([0, radius]);

var color = d3.scale.ordinal().range(colorScheme);


var divHeight = height;
var divWidth = width;

var svg = d3.select("#chart").append("svg")
.attr("width", width)
.attr("height", height)
.append("g")
.attr("transform", "translate(" + divWidth / 2 + "," + height / 2 + ") rotate(-90 0 0)");

var partition = d3.layout.partition()
.value(function(d) {
	return d.size;
});

var tooltip = d3.select("body")
.append("div")
.attr("class", "tooltip")
.style("position", "absolute")
.style("z-index", "10")
.style("opacity", 0);

var arc = d3.svg.arc()
.startAngle(function(d) {
	if (d.size != 0)
		return Math.max(0, Math.min(2 * Math.PI, x(d.x)));
})
.endAngle(function(d) {

	if (d.depth == 0)
		return Math.max(0, Math.min(2 * Math.PI, x(d.x + d.dx)));

	if (d.depth == 2) {
		return Math.max(0, Math.min(2 * Math.PI, x(d.x + d.dx)));
	}

	if (d.size != 0)
		return Math.max(0, Math.min(2 * Math.PI, x(d.x + d.dx)));
})
.innerRadius(function(d) {
	if (d.size != 0)
		return Math.max(0, y(d.y));
})
.outerRadius(function(d) {
	if (d.size != 0)
		return Math.max(0, y(d.y + d.dy));

});

var root = dataset;

var g = svg.selectAll("g")
.data(partition.nodes(root))
.enter().append("g");

var path = g.append("path")
.attr("d", arc)
.style("fill", function(d) {
	return color((d.children ? d : d.parent).name);
});
/*.on("click", click)
.on("mouseover", function(d) {
	tooltip.html(function() {
		return d.name + "<br>" + d.value;
	});
	return tooltip.transition()
	.duration(50)
	.style("opacity", 0.9);
})
.on("mousemove", function(d) {
	return tooltip
	.style("top", (d3.event.pageY-10)+"px")
	.style("left", (d3.event.pageX+10)+"px");
})
.on("mouseout", function(){return tooltip.style("opacity", 0);});*/


//.append("text")
var text = g.append("text")
.attr("x", function(d) {
    console.log(d.name);
    if(d.name=='Acupping'){
        return -35; 
    }else{
        return y(d.y);        
    }

})
.attr("dx", function(d) {
	return d.depth == 0 ? "9" : "9"
    }) // margin
    .attr("dy", ".35em") // vertical-align
    .attr("transform", function(d) {
    	return "rotate(" + computeTextRotation(d) + ")";
    })
    .text(function(d) {
    	return d.size == null ? d.name : d.name;
    })
    //.style("fill", "black");
    .style("font-weight", "bold");
    function computeTextRotation(d) {
    	var angle = x(d.x + d.dx / 2) - Math.PI / 2;
    	return angle / Math.PI * 180;
    }

    function click(d) {
    // fade out all text elements
    if (d.size !== undefined) {
    	d.size += 100;
    };
    text.transition().attr("opacity", 0);

    path.transition()
    .duration(750)
    .attrTween("d", arcTween(d))
    .each("end", function(e, i) {
            // check if the animated element's data e lies within the visible angle span given in d
            if (e.x >= d.x && e.x < (d.x + d.dx)) {
                // get a selection of the associated text element
                var arcText = d3.select(this.parentNode).select("text");
                // fade in the text element and recalculate positions
                arcText.transition().duration(750)
                .attr("opacity", 1)
                .attr("transform", function() {
                	return "rotate(" + computeTextRotation(e) + ")"
                })
                .attr("x", function(d) {
                	return y(d.y);
                });
            }
        });
} //});

// Word wrap!
var insertLinebreaks = function(t, d, width) {
	var el = d3.select(t);
	var p = d3.select(t.parentNode);
	p.append("g")
	.attr("x", function(d) {
		return y(d.y);
	})
        //.attr("dx", "6") // margin
        //.attr("dy", ".35em") // vertical-align
        .attr("transform", function(d) {
        	return "rotate(" + computeTextRotation(d) + ")";
        })
        //p
        .append("foreignObject")
        .attr('x', -width / 2)
        .attr("width", width)
        .attr("height", 200)
        .append("xhtml:p")
        .attr('style', 'word-wrap: break-word; text-align:center;')
        .html('d.name');
        el.remove();
    };

    d3.select(self.frameElement).style("height", height + "px");

// Interpolate the scales!
function arcTween(d) {
	var xd = d3.interpolate(x.domain(), [d.x, d.x + d.dx]),
	yd = d3.interpolate(y.domain(), [d.y, 1]),
	yr = d3.interpolate(y.range(), [d.y ? 20 : 0, radius]);
	return function(d, i) {
		return i ? function(t) {
			return arc(d);
		} : function(t) {
			x.domain(xd(t));
			y.domain(yd(t)).range(yr(t));
			return arc(d);
		};
	};
}