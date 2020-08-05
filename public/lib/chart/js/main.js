const data = {
  name: 'Acupping',
  color: '#ffffff',
  children: [{
    name: 'a',
    size : 1,
    color: '#bdbdbd',
      children: [{
        name: 'aa',
        color: '#bdbdbd',
        size : 150
      }, {
        name: 'ab',
        color: '#bdbdbd',
        size : 150
      }]
  },{
    name: 'b',
    color: '#bdbdbd',
    size : 2,
      children: [{
        name: 'ba',
        color: '#bdbdbd',
        size : 300
      }, {
        name: 'bb',
        color: '#bdbdbd',
        size : 300
      }]
  },{
    name: 'c',
    size : 3,
    color: '#bdbdbd',
      children: [{
        name: 'ca',
        color: '#bdbdbd',
        size : 450
      }, {
        name: 'cb',
        color: '#bdbdbd',
        size : 450
      }]
  }
  ]
};

Sunburst()
  .data(data)
  .size('size')
  .color('color')
  .radiusScaleExponent(1)
  (document.getElementById('chart'));