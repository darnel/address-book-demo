import React, { useEffect, useState } from 'react';
import { Link, useNavigate, useParams } from "react-router-dom";
import Form from 'react-bootstrap/Form';

import { BASE_URI } from "../config";
import { Button } from "react-bootstrap";

const AddressForm = () => {

  const { id } = useParams();
  const [data, setData] = useState({
    firstName: '',
    lastName: '',
    phone: '',
    email: '',
    note: '',
  });
  const [violations, setViolations] = useState([]);
  const navigate = useNavigate();

  const fetchData = () => {
    id && fetch(`${BASE_URI}/${id}`)
      .then(response => response.json())
      .then(json => setData(json));
  }

  useEffect(() => fetchData(), [id]);

  const handleSubmit = (e) => {
    const requestOptions = {
      method: id ? 'PUT' : 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    };
    const url = BASE_URI + (id ? `/${id}` : '');
    fetch(url, requestOptions)
      .then(async response => {
        const data = response.headers.get('content-type')?.includes('application/json') && await response.json();

        setViolations([]);

        if (!response.ok) {
          response.status === 422 && setViolations(data.violations);
          return Promise.reject(`${response.status} ${response.statusText}`);
        }

        navigate('/');
      })
      .catch(error => {
        console.log(error);
      })
  }

  const violation = (path) => {
    return violations
      .filter(v => (v.propertyPath === path))
      .map((v, i) => v.title);
  }

  const Feedback = ({ path }) => {
    return violation(path)
      .map((v, i) => <Form.Control.Feedback key={`${path}${i}`} type='invalid'>{v}</Form.Control.Feedback>)
  }

  return (
    <>
      {data && (
        <>
          <div className={'form'}>
            <Form noValidate>
              <Form.Group className={'mb-3'}>
                <Form.Label>Jméno</Form.Label>
                <Form.Control
                  type={'text'}
                  value={data.firstName}
                  isInvalid={violation('firstName').length > 0}
                  onChange={e => setData({ ...data, firstName: e.target.value })}
                />
                <Feedback path='firstName' />
              </Form.Group>
              <Form.Group className={'mb-3'}>
                <Form.Label>Příjmení</Form.Label>
                <Form.Control
                  type={'text'}
                  value={data.lastName}
                  isInvalid={violation('lastName').length > 0}
                  onChange={e => setData({ ...data, lastName: e.target.value })}
                />
                <Feedback path='lastName' />
              </Form.Group>
              <Form.Group className={'mb-3'}>
                <Form.Label>Telefon</Form.Label>
                <Form.Control
                  type={'text'}
                  value={data.phone}
                  isInvalid={violation('phone').length > 0}
                  onChange={e => setData({ ...data, phone: e.target.value })}
                />
                <Feedback path='phone' />
              </Form.Group>
              <Form.Group className={'mb-3'}>
                <Form.Label>E-mail</Form.Label>
                <Form.Control
                  type={'text'}
                  value={data.email}
                  isInvalid={violation('email').length > 0}
                  onChange={e => setData({ ...data, email: e.target.value })}
                />
                <Feedback path='email' />
              </Form.Group>
              <Form.Group className={'mb-3'}>
                <Form.Label>Poznámka</Form.Label>
                <Form.Control
                  as={'textarea'}
                  value={data.note}
                  isInvalid={violation('note').length > 0}
                  onChange={e => setData({ ...data, note: e.target.value })}
                />
                <Feedback path='note' />
              </Form.Group>
              <div className={'mb-3'}>
                <Button onClick={handleSubmit} variant={'primary'}>Uložit</Button>
              </div>
            </Form>
            <Link to="/" className="btn btn-danger">Zpět</Link>
          </div>
        </>
      )}
    </>
  );
}

export default AddressForm
