 // src/components/contacts.js

 import React from 'react';
 import { Card, Icon, Image } from 'semantic-ui-react';
 
import ReactDOM from 'react-dom';
var page = 0;
// var id_c;
class Popup extends React.Component {
  render() {
    return (
      <div className='popup'>
        <div className='popup_inner'>
          <h1>{this.props.text}</h1>
        <button onClick={this.props.closePopup}>close me</button>
        </div>
      </div>
    );
  }
}
class App extends React.Component {
  constructor() {
    super();
    this.state = {
      showPopup: false
    };
  }
  togglePopup() {
    this.setState({
      showPopup: !this.state.showPopup
    });
  }
  render() {
    return (
      <div className='app'>
        <h1>hihi</h1>
        <button onClick={this.togglePopup.bind(this)}>show popup</button>
        
        {this.state.showPopup ? 
          <Popup
            text='Close Me'
            closePopup={this.togglePopup.bind(this)}
          />
          : null
        }
      </div>
    );
  }
};

ReactDOM.render(
  <App />,
  document.getElementById('root')
);
//
var next = $v => 
{
  page++;
  componentDidMount($v);
}
var prev = $v => 
{
  if (page > 0)
  {
    page--;
    componentDidMount($v);
  }
}
var okcard = $va =>
{
  // App.this.togglePopup.bind(this);
  console.log($va);
}
 var componentDidMount = $e => 
 {
   var nombremax = 3;
  //  id_c = $e; 
   var value = '{"0":"'+ (nombremax * page) +'","1":"'+nombremax+'","2":true,"3":["genre_id","'+ $e +'"]}';
   fetch('http://localhost:99/my_spotify/rush_spotify/api/api_listing_albums.php?ListingAlbums=' + value)
   .then(res => res.json())
   .then((data) => {
     if(data[0] === false)
     {
      console.log(data);
      return false;
     }
     ReactDOM.render( <div>
       Page {page} <button onClick={() => prev($e)}>presedent</button> <button onClick={() => next($e)} >next</button>
        {data[1].map((ceontact) => (  
          <Card onClick = {() => okcard(ceontact)}>
          <Image src= {ceontact['cover']} wrapped ui={false} />
          <Card.Content>
            <Card.Header>Matthew</Card.Header>
            <Card.Meta>
              <span className='date'>{ceontact['name']} in 2015</span>
            </Card.Meta>
            <Card.Description>
              Matthew is a musician living in Nashville.
            </Card.Description>
          </Card.Content>
        </Card>
      ))
        }</div>
        , document.getElementById('music'));
   })
   .catch(console.log)

 
 }
 
  var Contacts = ({ contacts }) => {
    
   return (
    <div id='genre'>
    <center><h1>genre List</h1></center>
    {contacts.map((contact) => (
      <div className="card">
        <div className="card-body">
     
          <button onClick={() => componentDidMount(contact[0], (page = 0))} className="card-title"> {contact[1]} </button> 
          
        </div>
      </div>
    ))}
    <div id='music'>
      
   </div>
  </div>
   )
 };

 export default Contacts