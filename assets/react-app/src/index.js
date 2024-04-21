import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { createBrowserHistory } from 'history'

import 'bootstrap/dist/css/bootstrap.min.css';
import './index.css';
import AddressIndex from "./components/AddressIndex";
import AddressForm from "./components/AddressForm";

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <>
    <h1>Adresář</h1>
    <div className={'content'}>
      <BrowserRouter history={createBrowserHistory()}>
        <Routes>
          <Route path='/' element={<AddressIndex />} />
          <Route path='/create' element={<AddressForm method={'post'} />} />
          <Route path='/:id' element={<AddressForm method={'put'} />} />
        </Routes>
      </BrowserRouter>
    </div>
  </>
);
