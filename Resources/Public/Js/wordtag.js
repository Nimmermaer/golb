var fill = d3.scale.category20();
var words = [{"text":"This", "url":"http://google.com/"},
    {"text":"is", "url":"http://bing.com/"},
    {"text":"some", "url":"http://somewhere.com/"},
    {"text":"random", "url":"http://random.org/"},
    {"text":"text", "url":"http://text.com/"}]
var width = 800;
var height = 300;
for (var i = 0; i < words.length; i++) {
    words[i].size = 10 + Math.random() * 90;
}

d3.layout.cloud()
    .size([width, height])
    .words(words)
    .padding(5)
    .rotate(function() { return ~~ (Math.random() * 2) * 90; })
    .font("Impact")
    .fontSize(function(d) { return d.size;})
    .on("end", draw)
    .start();

function draw(words) {
    d3.select("body")
        .append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate("+ width/2 +","+ height/2 +")")
        .selectAll("text")
        .data(words)
        .enter()
        .append("text")
        .style("font-size", function(d) { return d.size + "px"; })
        .style("font-family", "Impact")
        .style("fill", function(d, i) { return fill(i); })
        .attr("text-anchor", "middle")
        .attr("transform", function(d) {
            return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
        })
        .text(function(d) { return d.text; })
        .on("click", function (d, i){
            window.open(d.url, "_blank");
        });
}