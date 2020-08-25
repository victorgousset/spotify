import './App.css';

import React, { Component } from 'react';
import Contacts from './components/contacts';
class genre extends Component {
  state = {
    contacts: []
  }
  componentDidMount() {
    fetch('http://localhost:99/my_spotify/rush_spotify/api/api_listing_genre.php')
    .then(res => res.json())
    .then((data) => {
      this.setState({ contacts: data })
    })
    .catch(console.log)
  }

  render()
  {
    return (

      <Contacts contacts={this.state.contacts} />
    );
  }
}
export default genre;

 