import unittest
from unittest.mock import patch, MagicMock, Mock
from app import app, Piece, PieceService

class TestPieceController(unittest.TestCase):

    @patch('app.PieceService')
    def test_list_pieces(self, mock_piece_service):
        # Mocking the PieceService instance
        mock_service_instance = mock_piece_service.return_value
        mock_service_instance.findPieceById.return_value = Piece(id=1, nom="Test Piece", qualite="High", reference="ABC123", quantite=10, prix=20.99)
        
        # Make a request to the API
        response = app.test_client().get('/api/pieces/1')
        data = response.get_json()

        # Assert that the response contains the expected data
        self.assertEqual(response.status_code, 200)
        self.assertEqual(data['nom'], "Test Piece")
        self.assertEqual(data['Qualite'], "High")
        self.assertEqual(data['Référence'], "ABC123")
        self.assertEqual(data['Quantité'], 10)
        self.assertEqual(data['Prix'], 20.99)

    def test_create_piece(self):
        # Mocking the request with JSON data
        mock_request = MagicMock()
        mock_request.get_json.return_value = {
            'nom': 'New Piece',
            'qualite': 'Medium',
            'reference': 'XYZ789',
            'quantite': 5,
            'prix': 15.99
        }

        # Mocking the PieceService instance
        mock_piece_service = Mock(spec=PieceService)
        mock_piece_service.createPiece.return_value = None

        # Call the create_piece function with the mock request and mock PieceService
        with patch('app.request', mock_request):
            with patch('app.PieceService', return_value=mock_piece_service):
                response = app.test_client().post('/api/pieces')
        
        # Assert that the response has status code 201 (created)
        self.assertEqual(response.status_code, 201)

    def test_modify_piece(self):
        # Mocking the request with JSON data
        mock_request = MagicMock()
        mock_request.get_json.return_value = {
            'nom': 'Updated Piece',
            'qualite': 'Low',
            'reference': 'DEF456',
            'quantite': 3,
            'prix': 10.99
        }

        # Mocking the PieceService instance
        mock_piece_service = Mock(spec=PieceService)
        mock_piece_service.findPieceById.return_value = Piece(id=1, nom="Test Piece", qualite="High", reference="ABC123", quantite=10, prix=20.99)
        mock_piece_service.deletePiece.return_value = None

        # Call the modify_piece function with the mock request and mock PieceService
        with patch('app.request', mock_request):
            with patch('app.PieceService', return_value=mock_piece_service):
                response = app.test_client().put('/api/pieces/1')
        
        # Assert that the response has status code 200 (OK)
        self.assertEqual(response.status_code, 200)

    def test_delete_piece(self):
        # Mocking the PieceService instance
        mock_piece_service = Mock(spec=PieceService)
        mock_piece_service.findPieceById.return_value = Piece(id=1, nom="Test Piece", qualite="High", reference="ABC123", quantite=10, prix=20.99)
        mock_piece_service.deletePiece.return_value = None

        # Call the delete_piece function with mock PieceService
        with patch('app.PieceService', return_value=mock_piece_service):
            response = app.test_client().delete('/api/pieces/1')
        
        # Assert that the response has status code 204 (No Content)
        self.assertEqual(response.status_code, 204)

    def test_search_piece_by_nom(self):
        # Mocking the PieceService instance
        mock_piece_service = Mock(spec=PieceService)
        mock_piece_service.findPieceByNom.return_value = [Piece(id=1, nom="Test Piece", qualite="High", reference="ABC123", quantite=10, prix=20.99)]

        # Make a request to the API
        response = app.test_client().get('/api/pieces/search/Test%20Piece')
        data = response.get_json()

        # Assert that the response contains the expected data
        self.assertEqual(response.status_code, 200)
        self.assertEqual(len(data), 1)
        self.assertEqual(data[0]['id'], 1)
        self.assertEqual(data[0]['nom'], "Test Piece")
        self.assertEqual(data[0]['Qualite'], "High")
        self.assertEqual(data[0]['Référence'], "ABC123")
        self.assertEqual(data[0]['Quantité'], 10)
        self.assertEqual(data[0]['Prix'], 20.99)

if __name__ == '__main__':
    unittest.main()
