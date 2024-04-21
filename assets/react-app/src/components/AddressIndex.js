import React, { useEffect, useState } from 'react';
import { Link } from "react-router-dom";
import { BASE_URI } from "../config";
import { Button, Modal } from "react-bootstrap";

const AddressIndex = () => {

  const [page, setPage] = useState(1);
  const [result, setResult] = useState([]);
  const [modal, setModal] = useState();

  const fetchData = () => {
    fetch(`${BASE_URI}?page=${page}`)
      .then(response => response.json())
      .then(json => setResult(json));
  }

  const handleDelete = (id) => {
    const requestOptions = {
      method: 'DELETE',
      headers: { 'Content-Type': 'application/json' }
    };

    fetch(`${BASE_URI}/${id}`, requestOptions)
      .then(async response => {
        if (!response.ok) {
          return Promise.reject(`${response.status} ${response.statusText}`);
        }

        //setResult({...result, data: data.filter(i => i.id !== id)});
        fetchData();
      })
      .catch(error => {
        console.log(error);
      })
  }

  const handleClose = () => {
    setModal(null);
  }

  useEffect(() => fetchData(), [page]);

  const { data, pages } = result;

  return (
    <>
      <Link to="/create" className="btn btn-success">Přidat</Link>

      {data && (
        <>
          <table className="table table-striped">
            <thead>
            <tr>
              <th>Příjmení</th>
              <th>Jméno</th>
              <th>Telefon</th>
              <th>E-mail</th>
              <th>Akce</th>
            </tr>
            </thead>
            <tbody>
            {data.map(item => (
              <tr key={item.id}>
                <td>{item.lastName}</td>
                <td>{item.firstName}</td>
                <td>{item.phone}</td>
                <td>{item.email}</td>
                <td>
                  <Button
                    onClick={() => setModal(item)}
                    variant="outline-dark"
                  >
                    Poznámka
                  </Button>
                  &nbsp;
                  <Link
                    to={`/${item.id}`}
                    className="btn btn-primary"
                  >
                    Editovat
                  </Link>
                  &nbsp;
                  <Button
                    onClick={() => handleDelete(item.id)}
                    variant="danger"
                  >
                    Smazat
                  </Button>
                </td>
              </tr>
            ))}
            </tbody>
          </table>

          <nav>
            <ul className="pagination">
              <li className={`page-item ${page === 1 && 'disabled'}`}>
                <Button onClick={() => {
                  setPage(page - 1)
                }} className="page-link">Předchozí</Button>
              </li>
              {Array.from({ length: pages }, (x, number) => (
                <li key={number} className={`page-item ${page === number + 1 && 'active'}`}>
                  <Button onClick={() => {
                    setPage(number + 1)
                  }} className="page-link">{number + 1}</Button>
                </li>
              ))}
              <li className={`page-item ${page === pages && 'disabled'}`}>
                <Button onClick={() => {
                  setPage(page + 1)
                }} className="page-link">Další</Button>
              </li>
            </ul>
          </nav>

          {modal && (<Modal show={modal} onHide={handleClose}>
            <Modal.Header closeButton>
              <Modal.Title>{modal.firstName} {modal.lastName}</Modal.Title>
            </Modal.Header>
            <Modal.Body>{modal.note}</Modal.Body>
            <Modal.Footer>
              <Button variant="secondary" onClick={handleClose}>
                Zavřít
              </Button>
            </Modal.Footer>
          </Modal>)}
        </>
      )}
    </>
  );
}

export default AddressIndex
